<?php


namespace App\Repositories\AdminPanel\Order;

use App\Models\Order;
use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderRepository
{

    private Order $model;
    private Customer $customerModel;

    public function __construct(Order $model, Customer $customerModel)
    {
        $this->model = $model;
        $this->customerModel = $customerModel;
    }

    public function store($validated)
    {

        return  DB::transaction(function () use ($validated) {

            try {
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
                    // 'payment_method' => $validated['paymentMethod'],
                    // 'status' => $validated['status'],
                ]);

                // save order items to order_product table
                // $orderProducts = $validated['products'];

                // foreach ($orderProducts as $orderProduct) {
                //     $order->products()->attach($orderProduct['id'], ['quantity' => $orderProduct['qty']]);
                // }

                $orderProducts = collect($validated['products'])->mapWithKeys(function ($product) {
                    return [$product['id'] => ['quantity' => $product['qty']]];
                })->toArray();

                $order->products()->sync($orderProducts);
            } catch (\Throwable $th) {
                info($th);
                throw new NotFoundHttpException('Not Found');
                return (500);
            }

            return (200);
        });
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

            info($order);
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
}
