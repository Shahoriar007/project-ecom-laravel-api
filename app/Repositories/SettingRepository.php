<?php

namespace App\Repositories;

use App\Models\Setting;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SettingRepository
{

    private Setting $model;

    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    public function index($request)
    {
        $select = $request->input('select', '');
        if (!empty($select)) {
            $select = explode(',', $select);
        }

        try {
            if (!$select) {
                return $this->model->take(1)->first();
            }
            return $this->model->select($select)->take(1)->first();
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }
    }

    public function update($validated)
    {
        try {
            $model = $this->model->take(1)->first();
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
}
