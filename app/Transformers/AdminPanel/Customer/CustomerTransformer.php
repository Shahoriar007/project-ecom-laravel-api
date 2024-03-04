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
            'full_name' => $customer->full_name ,
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'company_name' => $customer->company_name,
            'is_band' => $customer->is_band,
            'created_at' => $customer->created_at,

        ];
    }
}
