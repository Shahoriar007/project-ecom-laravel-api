<?php

namespace App\Http\Controllers\Api\V1\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\AdminPanel\Order\OrderRepository;
use App\Transformers\AdminPanel\Order\OrderTransformer;
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
        $validated = $request->validated();
        $data = $this->repository->store($validated);
        return $data;

    }

    public function index(Request $request)
    {
        info($request);
        $show = $request->input('show', 10);
        $sort = $request->input('sort', []);
        $search = $request->input('q');

        $data = $this->repository->index($show, $sort, $search);

        return $this->response->paginator($data, new OrderTransformer());
    }
}
