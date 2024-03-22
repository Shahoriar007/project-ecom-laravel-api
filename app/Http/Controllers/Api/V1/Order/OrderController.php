<?php

namespace App\Http\Controllers\Api\V1\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\NotificationTransformer;
use App\Repositories\AdminPanel\Order\OrderRepository;
use App\Transformers\AdminPanel\Order\OrderTransformer;
use App\Http\Requests\AdminPanel\Order\StoreOrderRequest;
use App\Transformers\MasterSettingTransformer;

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
        $rangeDate = $request->input('rangeDate');

        $data = $this->repository->index($show, $sort, $search, $filterStatus, $customerId, $rangeDate);

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
    }

    public function printInvoice()
    {
        return $this->repository->printInvoice();
    }

    public function printSticker(Request $request)
    {
        $orderIds = $request->orderIds;
        return $this->repository->printSticker($orderIds);
    }

    public function statusChangeMultiple(Request $request)
    {
        $this->repository->statusChangeMultiple($request->ids, $request->status);
        return $this->response()->noContent();
    }

    public function totalOrderAmount($id)
    {
        $data = $this->repository->totalOrderAmount($id);
        return response()->json($data);
    }

    // notification

    public function getUserUnreadNotifications()
    {
        $unreadNotifications =  $this->repository->getUserUnreadNotifications();

        return $this->response->collection($unreadNotifications, new NotificationTransformer());
    }

    public function markAsRead(Request $request)
    {
        $notification = $this->repository->markAsRead($request->id);
        return $this->response->item($notification, new NotificationTransformer());
    }

    // delivery charge
    public function getDeliveryCharge()
    {
        $data = $this->repository->getDeliveryCharge();
        return $this->response->collection($data, new MasterSettingTransformer());
    }

    public function updateDeliveryCharge(Request $request)
    {
        $data = $this->repository->updateDeliveryCharge($request);
        return $this->response->item($data, new MasterSettingTransformer());
    }

    // comment
    public function updateComment(Request $request)
    {
        $data = $this->repository->updateComment($request);
        return $this->response->item($data, new OrderTransformer());
    }

}
