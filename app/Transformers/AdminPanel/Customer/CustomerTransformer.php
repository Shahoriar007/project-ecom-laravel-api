<?php

namespace App\Transformers\AdminPanel\Customer;

use App\Models\Customer;
use League\Fractal\TransformerAbstract;

class CustomerTransformer extends TransformerAbstract
{


    public function transform(Customer $customer)
    {
        return [
            'id' => $customer->id,
            'name' => $customer->name,
            'phone' => $customer->phone,
            'status' => $customer->status,
            'email' => $customer->email,
            'created_at' =>  $customer->created_at,

        ];
    }
}
