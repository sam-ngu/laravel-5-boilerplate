<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\Auth\User;
use App\Helpers\Auth\Auth;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\User\ManageUserRequest;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    /**
     * Get the current logged in user
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentUser()
    {
        $user = auth()->user();
        return (new UserResource($user))->response();
    }



}
