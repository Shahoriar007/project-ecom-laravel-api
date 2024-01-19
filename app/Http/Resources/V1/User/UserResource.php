<?php

namespace App\Http\Resources\V1\User;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;


class UserResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $role = $this->roles()
            ->with('permissions')
            ->first();
        $permissions = $role->permissions ?? collect([]);

        return [
            'id' => $this->id,
            'avatar' => $this->getFirstMediaUrl('user-avatar', 'avatar'),
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'role' => $role->name ?? "",
            'permissions' => $permissions->map(fn ($perm) => $perm->name),
            'created_at' => $this->created_at->toFormattedDateString(),
        ];
    }
}
