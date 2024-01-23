<?php


namespace App\Repositories\AdminPanel\Product;



use Carbon\Carbon;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductRepository
{

    private Product $model;

    public function __construct(
        Product $model,

    ) {
        $this->model = $model;
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


        $query  = $this->model->query();

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
                        ...$validated,
                        'status' => to_boolean($validated['status']),
                        'is_flash_sale' => to_boolean($validated['is_flash_sale']),
                        'is_new_arrival' => to_boolean($validated['is_new_arrival']),
                        'is_hot_deal' => to_boolean($validated['is_hot_deal']),
                        'is_for_you' => to_boolean($validated['is_for_you']),
                        'created_by' => auth()->user()->id
                    ]
                );

                if ($request->hasFile('images')) {
                    if ($files =  $request->file('images')) {
                        foreach ($files as $file) {

                            $model->addMedia($file)->toMediaCollection('product_images');
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
            info($model);
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Product Not Found');
        }


        try {

            DB::transaction(function () use ($model, $request, $validated) {


                $oldImageIds = [];
                foreach ($model->getMedia('product_images')->toArray() as $image) {
                    $oldImageIds[] = $image['id'];
                }

                foreach ($oldImageIds as $id) {
                    $media = $model->getMedia('product_images')->where('id', $id)->first();
                    if ($media) {
                        $media->delete();
                    }
                }

                if ($request->hasFile('images')) {
                    if ($files =  $request->file('images')) {
                        foreach ($files as $file) {
                            $model->addMedia($file)->toMediaCollection('product_images');
                        }
                    }
                }

                $model->update([
                    ...$validated,
                    'status' => to_boolean($validated['status']),
                    'is_flash_sale' => to_boolean($validated['is_flash_sale']),
                    'is_new_arrival' => to_boolean($validated['is_new_arrival']),
                    'is_hot_deal' => to_boolean($validated['is_hot_deal']),
                    'is_for_you' => to_boolean($validated['is_for_you']),
                    'updated_by' => auth()->user()->id
                ]);
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
}
