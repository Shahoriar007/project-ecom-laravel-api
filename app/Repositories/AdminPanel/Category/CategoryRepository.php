<?php


namespace App\Repositories\AdminPanel\Category;


use Carbon\Carbon;

use App\Models\Category;

use Illuminate\Support\Facades\DB;

use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryRepository
{

    private Category $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        try {
            $query = $this->model->all();

            return $query;

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
        $query = $this->model->where('status', true)->get();
        $query->load('subCategories');
        $query->load('subCategories.childCategories');

        return $query;
    }

    public function featuredAll()
    {
        $query = $this->model->where('is_featured', true)->get();

        return $query;
    }

    public function findById($id)
    {
        try {
            $data = $this->model->findOrFail($id);
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
                        'created_by' => auth()->user()->id
                    ]
                );

                if ($request->hasFile('image')) {
                    $model->addMediaFromRequest('image')->toMediaCollection('category_image');
                }

                return $model;
            });
        } catch (\Throwable $th) {

            info($th);
            throw new StoreResourceFailedException('Category Create Failed');
        }
    }

    public function update($id, $validated, $request)
    {

        try {
            $model = $this->model->findOrFail($id);
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Category Not Found');
        }


        try {

            DB::transaction(function () use ($model, $request, $validated) {
                if ($request->hasFile('image')) {

                    $model->clearMediaCollection('category_image');
                    $model->addMediaFromRequest('image')->toMediaCollection('category_image');
                }
                $model->update([
                    ...$validated,
                    'status' => to_boolean($validated['status']),
                    'updated_by' => auth()->user()->id
                ]);
            });


            return $model->fresh();
        } catch (\Throwable $th) {
            info($th);
            throw new UpdateResourceFailedException('Update Error');
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

            throw new DeleteResourceFailedException('Delete Failed');
        }
    }

    // public function forceDelete($id)
    // {


    //     try {
    //         $user = $this->findById($id);
    //     } catch (\Throwable $th) {

    //         throw new NotFoundHttpException('Not Found');
    //     }

    //     try {
    //         $user->forceDelete();
    //     } catch (\Throwable $th) {

    //         throw new DeleteResourceFailedException('Delete Failed');
    //     }
    // }




}
