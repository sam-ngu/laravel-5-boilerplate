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
    Route::group([
        'namespace' => 'Auth',
        'prefix' => 'auth',

    ], function(){
        /*
        * All route names are prefixed with api.v1.auth
        * */
        Route::get('/session', "AuthController@session");
        Route::get('/login-as/{user}', "AuthController@loginAs");
        Route::get('/logout-as', "AuthController@logoutAs");
    });

    Route::group([
        'namespace' => 'User',
        'prefix' => 'user',
        'middleware' => [
            'role:'.config('access.users.admin_role')
        ]
    ], function(){
        /*
         * All route names are prefixed with api.v1.user
         * */
        Route::apiResource('/', 'UserController');
        Route::get('/current-user', 'UserController@currentLoggedIn');
//        Route::post('/deactivate', 'UserController');

    });

//    TODO: insert role api
//    TODO: insert permission api
//    TODO: insert permission api


});
