<?php

namespace App\Transformers;

use App\Models\Setting;
use League\Fractal\TransformerAbstract;

class SettingTransformer extends TransformerAbstract
{

    public function transform(Setting $setting)
    {
        return [
            'id' => $setting->id,
            'weekends' => $setting->weekends,
            'check_in_out_time' => $setting->check_in_out_time,
        ];
    }
}
