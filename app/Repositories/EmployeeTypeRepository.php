<?php

namespace App\Repositories;

use App\Models\EmployeeType;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EmployeeTypeRepository
{

    private EmployeeType $model;

    public function __construct(EmployeeType $model)
    {
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

    public function index()
    {
        try {
            return $this->model->get();
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }
    }

    public function findById($id)
    {
        try {
            return $this->model->findOrFail($id);
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }
    }

    public function store($validated)
    {
        try {
            return $this->model->create($validated);
        } catch (\Throwable $th) {
            throw new StoreResourceFailedException('Create Failed');
        }
    }

    public function update($id, $validated)
    {
        try {
            $model = $this->findById($id);
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }

        try {
            $model->update($validated);
            return $model->fresh();
        } catch (\Throwable $th) {
            throw new UpdateResourceFailedException('Update Failed');
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
}
