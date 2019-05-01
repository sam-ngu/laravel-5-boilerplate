<?php

namespace App\Http\Controllers\Api\V1\Permission;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Repositories\Backend\Auth\PermissionRepository;
use App\Repositories\Backend\Auth\RoleRepository;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * @var RoleRepository
     */
    protected $permissionRepository;


    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $pageSize = (int)$request->page_size ?? 25;
        $permissions = $this->permissionRepository;

        return PermissionResource::collection($permissions->paginate($pageSize))->response();
    }

}
