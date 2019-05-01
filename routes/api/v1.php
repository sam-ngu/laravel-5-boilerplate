<?php
/**
 * Created by PhpStorm.
 * User: sam
 * Date: 2/03/19
 * Time: 6:24 PM
 */
use App\Http\Controllers\Api\V1\User\UserController;

Route::group([
    'namespace' => 'V1',
    'prefix' => 'v1',
    'as' => 'v1.',

], function () {
    /**
     * All route names are prefixed with 'api.v1.'.
     */


    /*
     * Auth Routes
     * */
    Route::group([
        'namespace' => 'Auth',
        'prefix' => 'auth',
        'as' => 'auth.',
    ], function(){
        /*
        * All route names are prefixed with api.v1.auth
        * */

        /*Getting the current logged in user details*/
        Route::get('/current-user', "AuthController@currentUser");
    });


    /*
     * Role Routes
     * */
    Route::group([
        'namespace' => 'Role',
        'middleware' => [
            'role:'.config('access.users.admin_role')
        ],
    ], function (){
        /*
         * All route names are prefixed with api.v1.role
         * */
        Route::apiResource('roles', 'RoleController');
    });



    /*Permission Routes*/
    /*
     * Permission Routes
     * */
    Route::group([
        'namespace' => 'Permission',
        'middleware' => [
            'role:'.config('access.users.admin_role')
        ],
    ], function (){
        /*
         * All route names are prefixed with api.v1.permission
         * */
        Route::get('permissions', "PermissionController@index");

    });


    /*User routes*/
    Route::group([
        'namespace' => 'User',
        'middleware' => [
            'role:'.config('access.users.admin_role')
        ]
    ], function(){
        /*
         * All route names are prefixed with api.v1.user
         * */

        /*User routes*/
        Route::apiResource('users', 'UserController');
        Route::get('users/current-user', 'UserController@currentLoggedIn');

    });



});
