<?php

namespace App\Repositories\Api\V1;

use App\Exceptions\GeneralJsonException;
use App\Models\Auth\User;
use App\Repositories\Api\BaseCrudRepository;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Events\Backend\Auth\User\UserCreated;
use App\Events\Backend\Auth\User\UserUpdated;
use App\Events\Backend\Auth\User\UserRestored;
use App\Events\Backend\Auth\User\UserPermanentlyDeleted;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;

/**
 * Class UserRepository.
 */
class UserRepository extends BaseCrudRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return User::class;
    }


    /**
     * @param array $data
     *
     * @return User
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = parent::create([
                'first_name'         => data_get($data, 'first_name'),
                'last_name'          => data_get($data, 'last_name'),
                'email'              => data_get($data, 'email'),
                'password'           => data_get($data, 'password'),
                'active'             => isset($data['active']) && $data['active'] == '1' ? 1 : 0,
                'confirmation_code'  => md5(uniqid(mt_rand(), true)),
                'confirmed'          => isset($data['confirmed']) && $data['confirmed'] == '1' ? 1 : 0,
            ]);

            // See if adding any additional permissions
            if (!isset($data['permissions']) || !count($data['permissions'])) {
                $data['permissions'] = [];
            }

            /** @var User $user */
            if ($user) {
                // User must have at least one role
                if (!count(data_get($data, 'roles', []))) {
                    throw new GeneralJsonException('Role needed');
                }

                // Add selected roles/permissions
                $user->syncRoles(data_get($data, 'roles'));
                $user->syncPermissions(data_get($data, 'permissions'));


                //Send confirmation email if requested and account approval is off
                if (isset($data['confirmation_email']) && $user->confirmed == 0 && !config('access.users.requires_approval')) {
                    $user->notify(new UserNeedsConfirmation($user->confirmation_code));
                }

                event(new UserCreated($user));

                return $user;
            }

            throw new GeneralException(__('exceptions.backend.access.users.create_error'));
        });
    }

    /**
     * @param User $user
     * @param array $data
     *
     * @return User
     * @throws GeneralException
     * @throws \Exception
     * @throws \Throwable
     */
    public function update($user, array $data): User
    {

        // See if adding any additional permissions
        if (!isset($data['permissions']) || !count($data['permissions'])) {
            $data['permissions'] = [];
        }

        return DB::transaction(function () use ($user, $data) {
            if ($user->update([
                'first_name'         => data_get($data, 'first_name') ?? data_get($user, 'first_name'),
                'last_name'          => data_get($data, 'last_name') ?? data_get($user, 'last_name'),
                'email'              => data_get($data, 'email') ?? data_get($user, 'email'),
                'company_id'         => data_get($data, 'company_id') ?? data_get($user, 'company_id'),
            ])) {
                // Add selected roles/permissions
                $user->syncRoles(data_get($data, 'roles') ?? data_get($user, 'roles'));
                $user->syncPermissions(data_get($data, 'permissions') ?? data_get($user, 'permissions'));

                event(new UserUpdated($user));

                return $user;
            }

            throw new GeneralException(__('exceptions.backend.access.users.update_error'));
        });
    }


    /**
     * @param User $user
     *
     * @return User
     * @throws GeneralException
     * @throws \Exception
     * @throws \Throwable
     */
    public function forceDelete($user): User
    {
        if (is_null($user->deleted_at)) {
            throw new GeneralException(__('exceptions.backend.access.users.delete_first'));
        }

        return DB::transaction(function () use ($user) {
            // Delete associated relationships
            $user->passwordHistories()->delete();
            $user->providers()->delete();
            $user->sessions()->delete();


            if ($user->forceDelete()) {
                event(new UserPermanentlyDeleted($user));

                return $user;
            }

            throw new GeneralException(__('exceptions.backend.access.users.delete_error'));
        });
    }

    /**
     * @param User $user
     *
     * @return User
     * @throws GeneralException
     */
    public function restore($user): User
    {
        if (is_null($user->deleted_at)) {
            throw new GeneralException(__('exceptions.backend.access.users.cant_restore'));
        }

        if ($user->restore()) {
            event(new UserRestored($user));

            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.restore_error'));
    }

}