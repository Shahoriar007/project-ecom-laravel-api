<?php

namespace App\Http\Controllers\Api\V1\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\AdminPanel\Order\OrderRepository;
use App\Http\Requests\AdminPanel\Order\StoreOrderRequest;

class OrderController extends Controller
{
    private OrderRepository $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(StoreOrderRequest $request)
    {
        info("im in controller");
        $validated = $request->validated();
        $data = $this->repository->store($validated);
        info($data);

    }
}
