<?php


namespace App\Repositories\AdminPanel\Customer;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomerRepository
{

    private Customer $model;

    public function __construct(Customer $model)
    {
        $this->model = $model;
    }

    public function index($show, $sort, $search)
    {
        $query  = $this->model->query();

        if (!empty($search)) {
            $query->where('name', 'LIKE', "%$search%");
        }

        // foreach ($sort as $key => $value) {
        //     $decode_data = json_decode($value);
        //     $query->orderBy($decode_data->field, $decode_data->type);
        // }

        return $query->paginate($show);


    }

    public function bandActive($id)
    {
        $data = $this->model->find($id);
        if (!$data) {
            throw new NotFoundHttpException('Data not found');
        }

        DB::beginTransaction();
        try {
            $data->is_band = !$data->is_band;
            $data->save();
            DB::commit();
            return $data;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }




}
