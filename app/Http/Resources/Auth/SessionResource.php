<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = auth()->user();
        $admin_user_id = session()->get('admin_user_id');
        $admin_user_name = session()->get('admin_user_name');
        $temp_user_id = session()->get('temp_user_id');
        return [
            'user' => $user->toArray(),  // resourse is a user model
            'session' => session()->all(),
        ];
    }
}
