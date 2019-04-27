<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Events\Backend\Auth\User\UserDeleted;
use App\Exceptions\GeneralException;
use App\Helpers\Auth\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\User\ManageUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Auth\User;
use App\Repositories\Backend\Auth\UserRepository;
use function DeepCopy\deep_copy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psy\Util\Json;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;


    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $searchKeyword = (string)$request->search_keywords ?? null;
        $pageSize = (int)$request->page_size ?? 25;
        $users = (new UserRepository());

        if($searchKeyword){
            $searchKeyword .= "%";
            $users = $users->searchActiveByName($searchKeyword, 'id', 'asc');
        }else{
            $users = $users->getActive('id', 'asc');
        }

        return UserResource::collection($users->paginate($pageSize))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $result = $this->userRepository->create($request->only(
            'first_name',
            'last_name',
            'email',
            'password',
            'active',
            'confirmed',
            'confirmation_email',
            'roles',
            'permissions'
        ));
        return (new UserResource($result))->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
//        $user = (new UserRepository())->getById((int)$id);
        return (new UserResource($user))->response();
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user)
    {
        $result = $this->userRepository->update($user, $request->only(
            'first_name',
            'last_name',
            'email',
            'roles',
            'permissions'
        ));
        if($request->password){
            $result = $this->userRepository->updatePassword($user, $request->only('password'));
        }
        return (new UserResource($result))->response();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $result = $this->userRepository->deleteById($user->id);

        event(new UserDeleted($user));

        return JsonResponse::create(["status" => "success", "data" => null]);
    }



}
