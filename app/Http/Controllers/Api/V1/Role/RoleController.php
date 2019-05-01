<?php

namespace App\Http\Controllers\Api\V1\Role;

use App\Events\Backend\Auth\Role\RoleDeleted;
use App\Exceptions\GeneralException;
use App\Helpers\Auth\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\Role\ManageRoleRequest;
use App\Http\Requests\Backend\Auth\Role\StoreRoleRequest;
use App\Http\Requests\Backend\Auth\Role\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Auth\Role;
use App\Repositories\Backend\Auth\RoleRepository;
use function DeepCopy\deep_copy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psy\Util\Json;

class RoleController extends Controller
{
    /**
     * @var RoleRepository
     */
    protected $roleRepository;


    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $pageSize = (int)$request->page_size ?? 25;
        $roles = (new RoleRepository())
            ->with('users', 'permissions')
            ->orderBy('id', 'asc');

        return RoleResource::collection($roles->paginate($pageSize))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRoleRequest $request)
    {
        $result = $this->roleRepository->create($request->only('name', 'associated-permissions', 'permissions', 'sort', 'guard_name'));

        return (new RoleResource($result))->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Role $role)
    {
        return (new RoleResource($role))->response();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $result = $this->roleRepository->update($role, $request->only('name', 'permissions'));
        return (new RoleResource($result))->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        $result = $this->roleRepository->deleteById($role->id);

        event(new RoleDeleted($role));

        return JsonResponse::create(["status" => "success", "data" => null]);
    }



}
