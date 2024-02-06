<?php


namespace App\Repositories\AdminPanel\Order;

use App\Models\Order;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderRepository
{

    private Order $model;

    public function __construct(
        Order $model,

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
