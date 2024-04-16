<?php

namespace App\Transformers\AdminPanel\FollowUp;

use App\Models\FollowUp;
use App\Transformers\UserTransformer;
use League\Fractal\TransformerAbstract;
use App\Transformers\AdminPanel\Order\OrderTransformer;

class FollowUpTransformer extends TransformerAbstract
{
    public function transform(FollowUp $followUp)
    {
        return [
            'id' => $followUp->id,
            'order_id' => $followUp->order_id,
            'user_id' => $followUp->user_id,
            'user' => $followUp->user,
            'msg' => $followUp->msg,
            'created_at' => $followUp->created_at,
            'updated_at' => $followUp->updated_at,
        ];
    }

    public function includeUser(FollowUp $followUp)
    {
        return $this->item($followUp->user, new UserTransformer());
    }

    public function includeOrder(FollowUp $followUp)
    {
        return $this->item($followUp->order, new OrderTransformer());
    }

}
