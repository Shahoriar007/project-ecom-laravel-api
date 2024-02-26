<?php


namespace App\Repositories\AdminPanel\Order;

use App\Models\Customer;
use App\Models\Order;
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
                        'first_name' => $validated['firstName'],
                        'last_name' => $validated['lastName'],
                        'email' => $validated['email'],
                        'phone' => $validated['phone'],
                        'company_name' => $validated['companyName'],
                    ]);
                } else{
                    $customer = $this->customerModel->create([
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
            }
            return "Order Created";
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
}
