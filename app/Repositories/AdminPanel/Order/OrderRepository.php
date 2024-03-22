<?php


namespace App\Repositories\AdminPanel\Order;

use App\Models\User;
use App\Models\Order;
use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\DatabaseNotification;
use App\Models\MasterSetting;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewOrderNotification;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderRepository
{

    private Order $model;
    private Customer $customerModel;
    private User $user;
    private DatabaseNotification $notificationModel;
    private MasterSetting $masterSetting;


    public function __construct(Order $model, Customer $customerModel, User $user, DatabaseNotification $notificationModel, MasterSetting $masterSetting)
    {
        $this->model = $model;
        $this->customerModel = $customerModel;
        $this->user = $user;
        $this->notificationModel = $notificationModel;
        $this->masterSetting = $masterSetting;
    }


    public function store($validated)
    {
        try {
            return DB::transaction(function () use ($validated) {
                //check from customer table if customer exists with phone or email
                $customer = $this->customerModel->where('email', $validated['email'])->orWhere('phone', $validated['phone'])->first();

                // save customer data to customer table
                if ($customer) {
                    $customer->update([
                        'full_name' => $validated['fullName'],
                        'first_name' => $validated['firstName'],
                        'last_name' => $validated['lastName'],
                        'email' => $validated['email'],
                        'phone' => $validated['phone'],
                        'company_name' => $validated['companyName'],
                    ]);
                } else {
                    $customer = $this->customerModel->create([
                        'full_name' => $validated['fullName'],
                        'first_name' => $validated['firstName'],
                        'last_name' => $validated['lastName'],
                        'email' => $validated['email'],
                        'phone' => $validated['phone'],
                        'company_name' => $validated['companyName'],
                    ]);
                }

                // save order data to order table
                $order = $this->model->create([
                    'customer_id' => $customer->id,
                    'delivery_charge' => $validated['deliveryCharge'],
                    'vat' => $validated['vat'] ?? 0,
                    'tax' => $validated['tax'] ?? 0,
                    'discount' => $validated['discount'] ?? 0,
                    'total_price' => $validated['totalPrice'],
                    'company_name' => $validated['companyName'],
                    'country_name' => $validated['countryName'],
                    'city_name' => $validated['cityName'],
                    'detail_address' => $validated['detailAddress'],
                    'order_notes' => $validated['orderNotes'],
                    'order_from' => $validated['orderFrom'],
                    // 'payment_method' => $validated['paymentMethod'],
                    // 'status' => $validated['status'],
                ]);

                $orderProducts = collect($validated['products'])->mapWithKeys(function ($product) {
                    return [$product['id'] => ['quantity' => $product['qty']]];
                })->toArray();

                $order->products()->sync($orderProducts);

                // send notification to customer
                $users = $this->user->all();
                $this->sendNotification($users, $order);

                return (200);
            });
        } catch (\Throwable $th) {
            info($th);
            throw new NotFoundHttpException('Not Found');
            return (500);
        }
    }

    public function sendNotification($notifiableUsers, $order)
    {
        Notification::send($notifiableUsers, new NewOrderNotification($order));
    }

    public function all()
    {
        try {
            return $this->model->all();
        } catch (\Throwable $th) {

            throw new NotFoundHttpException('Not Found');
        }
    }

    public function index($show, $sort, $search, $filterStatus, $customerId, $rangeDate)
    {
        $query  = $this->model->query();
        $query->orderBy('id', 'desc');

        if (!empty($customerId)) {
            $query->where('customer_id', $customerId);
        }

        if (!empty($search)) {
            $query->where('detail_address', 'LIKE', "%$search%")
                ->orWhere('id', 'LIKE', "%$search%")
                ->orWhereHas('customer', function ($query) use ($search) {
                    $query->where('full_name', 'LIKE', "%$search%");
                });
        }

        if (!empty($rangeDate)) {
            info($rangeDate);

            if (strpos($rangeDate, ' to ') !== false) {
                // $rangeDate is a range like "2024-03-04 to 2024-03-06"
                $date = explode(' to ', $rangeDate);
                // Add one day to the end date
                $endDate = date('Y-m-d', strtotime($date[1] . ' +1 day'));
                $query->whereBetween('created_at', [$date[0], $endDate]);
            } else {
                // $rangeDate is a single date like "2024-03-04"
                $query->whereDate('created_at', $rangeDate);
            }
        }

        if (!empty($filterStatus) && $filterStatus == 'all') {
            $query->where('status', '!=', 'deleted');
        } elseif (!empty($filterStatus)) {
            $query->where('status', $filterStatus);
        }

        // foreach ($sort as $key => $value) {
        //     $decode_data = json_decode($value);
        //     $query->orderBy($decode_data->field, $decode_data->type);
        // }

        return $query->paginate($show);
    }

    public function details($id)
    {
        try {
            $query = $this->model->findOrFail($id);
            return $query;
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }
    }

    public function updateOrderStatus($request)
    {
        try {
            $order = $this->model->findOrFail($request->id);

            $order->update([
                'status' => $request->status
            ]);
            return "Order Status Updated";
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }
    }

    public function printInvoice()
    {
        $pdf = Pdf::setOption([
            'dpi' => 150,
            'isPhpEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'isFontSubsettingEnabled' => true,
            // 'defaultMediaType' => 'print',
            'defaultFont' => 'Open Sans'
        ])->loadView('pdf.invoice');

        return $pdf->download('invoice.pdf');
    }

    public function printSticker($orderIds)
    {
        try {
            $orders = $this->model->whereIn('id', $orderIds)->get();

            $htmlContent = '';

            foreach ($orders as $order) {
                // Render the 'pdf.sticker' view with the order data and get the HTML content
                $view = view('pdf.sticker', ['order' => $order]);
                $htmlContent .= $view->render();
            }

            // Create a new PDF with the combined HTML content
            $pdf = Pdf::setOption([
                'dpi' => 150,
                'isPhpEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'isFontSubsettingEnabled' => true,
                'defaultFont' => 'Open Sans'
            ])->loadHTML($htmlContent);

            return $pdf->download('stickers.pdf');
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }
    }

    public function statusChangeMultiple($ids, $status)
    {
        try {

            $orders = $this->model->whereIn('id', $ids)->get();

            foreach ($orders as $order) {
                $order->update([
                    'status' => $status
                ]);
            }
            return "Order Status Updated";
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }
    }

    public function totalOrderAmount($id)
    {
        try {
            $totalOrderAmount = $this->model->where('customer_id', $id)->sum('total_price');
            $totalPendingCount = $this->model->where('customer_id', $id)->where('status', 'pending')->count();
            $totalPending1Count = $this->model->where('customer_id', $id)->where('status', 'pending-1')->count();
            $totalPending2Count = $this->model->where('customer_id', $id)->where('status', 'pending-2')->count();
            $totalProcessingCount = $this->model->where('customer_id', $id)->where('status', 'processing')->count();
            $totalPackagingCount = $this->model->where('customer_id', $id)->where('status', 'packaging')->count();
            $totalShippingCount = $this->model->where('customer_id', $id)->where('status', 'shipping')->count();
            $totalOnTheWayCount = $this->model->where('customer_id', $id)->where('status', 'on_the_way')->count();
            $totalInReviewCount = $this->model->where('customer_id', $id)->where('status', 'in_review')->count();
            $totalCancelledCount = $this->model->where('customer_id', $id)->where('status', 'canceled')->count();
            $totalDeliveredCount = $this->model->where('customer_id', $id)->where('status', 'delivered')->count();
            $totalReturnedCount = $this->model->where('customer_id', $id)->where('status', 'returned')->count();
            return [
                'totalOrderAmount' => $totalOrderAmount,
                'totalPendingCount' => $totalPendingCount,
                'totalPending1Count' => $totalPending1Count,
                'totalPending2Count' => $totalPending2Count,
                'totalProcessingCount' => $totalProcessingCount,
                'totalPackagingCount' => $totalPackagingCount,
                'totalShippingCount' => $totalShippingCount,
                'totalOnTheWayCount' => $totalOnTheWayCount,
                'totalInReviewCount' => $totalInReviewCount,
                'totalCancelledCount' => $totalCancelledCount,
                'totalDeliveredCount' => $totalDeliveredCount,
                'totalReturnedCount' => $totalReturnedCount,
            ];
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }
    }

    public function getUserUnreadNotifications()
    {
        try {
            $user = $this->user->findOrFail(Auth::user()->id);
            return $user->unreadNotifications;
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Unread Notifications Not Found');
        }
    }

    public function markAsRead($id)
    {
        try {
            $notification = $this->notificationModel->findOrFail($id);
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Notification Not Found');
        }

        try {
            $notification->markAsRead();
            return $notification;
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Notification Read Failed');
        }
    }

    public function getDeliveryCharge()
    {
        try {
            $deliveryCharge = $this->masterSetting->get();
            return $deliveryCharge;
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Delivery Charge Not Found');
        }
    }

    public function updateDeliveryCharge($request)
    {
        try {
            $deliveryCharge = $this->masterSetting->first();
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Delivery Charge Not Found');
        }

        try {
            $deliveryCharge->update([
                'inside_dhaka' => $request->inside_dhaka,
                'outside_dhaka' => $request->outside_dhaka,
            ]);
            return $deliveryCharge;
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Delivery Charge Update Failed');
        }
    }

    public function updateComment($request)
    {
        try {
            $order = $this->model->findOrFail($request['id']);
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Order Not Found');
        }

        try {
            $order->update([
                'comment' => $request->comment
            ]);
            return $order;
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Comment Update Failed');
        }
    }
}
