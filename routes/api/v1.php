<?php
/**
 * Created by PhpStorm.
 * User: sam
 * Date: 2/03/19
 * Time: 6:24 PM
 */
use App\Http\Controllers\Api\V1\UserController;

Route::group([
    'namespace' => 'V1',
    'prefix' => 'v1',
    'as' => 'v1.',

], function () {
    /**
     * All route names are prefixed with 'api.v1.'.
     */
    Route::apiResource('user', 'UserController');
//    TODO: insert role api
//    TODO: insert permission api
//    TODO: insert permission api


});
