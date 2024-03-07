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
        $show = $request->input('show', 10);
        $sort = $request->input('sort', []);
        $search = $request->input('q');
        $filterStatus = $request->input('filterStatus');
        $customerId = $request->input('customerId');

        $data = $this->repository->index($show, $sort, $search, $filterStatus, $customerId);

        return $this->response->paginator($data, new OrderTransformer());
    }

    public function details($id)
    {
        $data = $this->repository->details($id);
        return $this->response->item($data, new OrderTransformer());
    }

    public function updateOrderStatus(Request $request)
    {
        return $this->repository->updateOrderStatus($request);
        info($request);
    }
}
