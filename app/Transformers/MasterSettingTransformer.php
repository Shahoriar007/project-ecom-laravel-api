<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class MasterSettingTransformer extends TransformerAbstract
{
    public function transform($masterSetting)
    {
        return [
            'id' => $masterSetting->id,
            'inside_dhaka' => $masterSetting->inside_dhaka,
            'outside_dhaka' => $masterSetting->outside_dhaka,
        ];
    }
}
