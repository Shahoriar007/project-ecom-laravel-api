<?php

namespace App\Transformers;

use App\Models\Module;
use League\Fractal\TransformerAbstract;
use App\Transformers\PermissionTransformer;

class ModuleTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['permissions'];

    public function transform(Module $module)
    {
        return [
            'id' => $module->id,
            'name' => $module->name,
            'created_at' =>  $module->created_at ? $module->created_at->toFormattedDateString() : null,
            "updated_at" =>  $module->updated_at ? $module->updated_at->toFormattedDateString() : null,
        ];
    }

    public function includePermissions(Module $module)
    {
        if (isset($module->permissions)) {
            return $this->collection($module->permissions, new PermissionTransformer());
        }
    }
}
