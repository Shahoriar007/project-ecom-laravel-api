<?php


namespace App\Repositories\AdminPanel\FbPixel;


use Carbon\Carbon;

use App\Models\FbPixel;
use Illuminate\Support\Facades\DB;

use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FbPixelRepository
{

    private FbPixel $model;

    public function __construct(FbPixel $model)
    {
        $this->model = $model;
    }

    public function index($show, $sort, $search)
    {


        $query  = $this->model->query();


        foreach ($sort as $key => $value) {
            $decode_data = json_decode($value);
            $query->orderBy($decode_data->field, $decode_data->type);
        }

        return $query->paginate($show);
    }


    public function findById($id)
    {
        try {
            $data = $this->model->findOrFail($id);

            info($data);
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
                        'created_by' => auth()->user()->id
                    ]
                );

                return $model;
            });
        } catch (\Throwable $th) {

            info($th);
            throw new StoreResourceFailedException('Category Create Failed');
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
            // $data->delete();
        } catch (\Throwable $th) {

            throw new DeleteResourceFailedException('Delete Failed');
        }
    }
}
