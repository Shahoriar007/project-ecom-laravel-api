<?php


namespace App\Repositories\AdminPanel\Product;



use Carbon\Carbon;

use App\Models\Label;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductRepository
{

    private Product $model;
    private Label $labelModel;

    public function __construct(
        Product $model,
        Label $labelModel

    ) {
        $this->model = $model;
        $this->labelModel = $labelModel;
    }

    public function all()
    {
        try {
            return $this->model->all();
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }
    }

    public function index($show, $sort, $search)
    {
        $query  = $this->model->query()->with(['labels', 'categories']);

        if (!empty($search)) {
            $query->where('name', 'LIKE', "%$search%");
        }

        foreach ($sort as $key => $value) {
            $decode_data = json_decode($value);
            $query->orderBy($decode_data->field, $decode_data->type);
        }

        return $query->paginate($show);
    }

    public function activeAll()
    {

        return $this->model->where('status', true)->get();
    }

    public function findById($id)
    {
        try {
            $data = $this->model->findOrFail($id);

            if ($data->hasMedia('category_image')) {
                $data['category_image_url'] = $data->getFirstMediaUrl('category_image');
            }

            return $data;
        } catch (\Throwable $th) {

            throw new NotFoundHttpException('Not Found');
        }
    }



    public function store($validated, $request)
    {
        try {
            return  DB::transaction(function () use ($validated, $request) {

                $model = $this->model->create(
                    [
                        'name' => $validated['name'],
                        'price' => $validated['price'],
                        'sku' => $validated['sku'],
                        'stock' => $validated['stock'],
                        'short_description' => $validated['short_description'],
                        'category_id' => $validated['category_id'],
                        'sub_category_id' => $validated['sub_category_id'] ?? null,
                        'child_category_id' => $validated['child_category_id'] ?? null,
                        'offer_notice' => $validated['offer_notice'],
                        'status' => to_boolean($validated['status']),
                        'sale_price' => $validated['sale_price'],
                        'is_hot' => to_boolean($validated['is_hot']),
                        'is_sale' => to_boolean($validated['is_sale']),
                        'is_new' => to_boolean($validated['is_new']),
                        'is_for_you' => to_boolean($validated['is_for_you']),
                        'created_by' => auth()->user()->id
                    ]
                );

                // $categoryIds = [];
                // foreach ($validated['category_id'] as $id) {
                //     $categoryIds[] = $id;
                // }


                // $model->categories()->attach($categoryIds);

                foreach ($validated['labels'] as $name) {
                    $label =  $this->labelModel->updateOrCreate(
                        ['name' => $name],
                        ['name' => $name]
                    );
                    $model->labels()->attach($label->id);
                }

                if ($request->hasFile('small_pictures')) {
                    if ($files =  $request->file('small_pictures')) {
                        foreach ($files as $file) {
                            $model->addMedia($file)->toMediaCollection('small_pictures');
                        }
                    }
                }
                if ($request->hasFile('large_pictures')) {
                    if ($files =  $request->file('large_pictures')) {
                        foreach ($files as $file) {
                            $model->addMedia($file)->toMediaCollection('large_pictures');
                        }
                    }
                }
                return $model;
            });
        } catch (\Throwable $th) {

            info($th);
            throw new StoreResourceFailedException('Product Create Failed');
        }
    }

    public function update($id, $validated, $request)
    {

        try {
            $model = $this->model->findOrFail($id);
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Product Not Found');
        }


        try {

            DB::transaction(function () use ($model, $request, $validated) {
                $oldImageIds = [];
                foreach ($model->getMedia('large_pictures')->toArray() as $image) {
                    $oldImageIds[] = $image['id'];
                }

                if ($validated['remove_all_image']) {
                    foreach ($oldImageIds as $id) {
                        $media = $model->getMedia('large_pictures')->where('id', $id)->first();
                        if ($media) {
                            $media->delete();
                        }
                    }
                }


                if ($request->hasFile('large_pictures')) {
                    if ($files =  $request->file('large_pictures')) {
                        foreach ($files as $file) {
                            $model->addMedia($file)->toMediaCollection('large_pictures');
                        }
                    }
                }

                $model->update([
                    'name' => $validated['name'],
                    'status' => to_boolean($validated['status']),
                    'short_description' => $validated['short_description'],
                    'offer_notice' => $validated['offer_notice'],
                    'price' => $validated['price'],
                    'sale_price' => $validated['sale_price'],
                    'stock' => $validated['stock'],
                    'sku' => $validated['sku'],
                    'category_id' => $validated['category_id'],
                    'sub_category_id' => $validated['sub_category_id'] ?? null,
                    'child_category_id' => $validated['child_category_id'] ?? null,
                    'is_hot' => to_boolean($validated['is_hot']),
                    'is_sale' => to_boolean($validated['is_sale']),
                    'is_new' => to_boolean($validated['is_new']),
                    'is_for_you' => to_boolean($validated['is_for_you']),
                    'updated_by' => auth()->user()->id
                ]);


                // $categoryIds = [];
                // foreach ($validated['category_id'] as $id) {
                //     $categoryIds[] = $id;
                // }
                // $model->categories()->sync($categoryIds);

                $labelIds = [];
                foreach ($validated['labels'] as $name) {

                    $label =  $this->labelModel->where('name', $name)->first();
                    if ($label == null) {
                        $label =  $this->labelModel->create(
                            ['name' => $name]
                        );
                    }
                    $labelIds[] = $label->id;
                }
                $model->labels()->sync($labelIds);
            });

            return $model->fresh();
        } catch (\Throwable $th) {
            info($th);
            throw new UpdateResourceFailedException('Product Update Error');
        }
    }



    public function delete($id)
    {
        try {
            $data = $this->findById($id);
        } catch (\Throwable $th) {

            throw new NotFoundHttpException('Not Found');
        }

        try {
            $data->delete();
        } catch (\Throwable $th) {
            throw new DeleteResourceFailedException('Product Delete Failed');
        }
    }

    public function showWithSlug($slug)
    {
        try {
            $data = $this->model->where('slug', $slug)->first();
            if ($data->hasMedia('large_pictures')) {
                $data['large_pictures_url'] = $data->getFirstMediaUrl('large_pictures');
            }
            return $data;
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }
    }

    public function totalProducts()
    {
        return $this->model->count();
    }
}
