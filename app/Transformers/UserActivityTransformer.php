<?php

namespace App\Transformers;

use App\Models\UserActivity;
use League\Fractal\TransformerAbstract;

class UserActivityTransformer extends TransformerAbstract
{

    public function transform(UserActivity $userActivity)
    {
        return [
            'id' => $userActivity->id,
            'user_id' => $userActivity->user_id,
            'order_id' => $userActivity->order_id,
            'order' =>  $userActivity->order,
            'previous_order_status' => $userActivity->previous_order_status,
            'current_order_status' => $userActivity->current_order_status,
            'created_at' => $userActivity->created_at,
            'updated_at' => $userActivity->updated_at,
        ];
    }




}
