<?php


namespace App\Repositories\AdminPanel\Label;


use App\Models\Category;
use App\Models\Label;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LabelRepository
{

    private Label $model;

    public function __construct(
        Label $model,

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
}
