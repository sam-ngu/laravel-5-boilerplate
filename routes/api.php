<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group([
    'namespace' => 'Api',
    'as' => 'api.',
    'middleware' => [
        'auth:api',
        \App\Http\Middleware\ParseFormData::class
    ]
], function (){
    /**
     * All route names are prefixed with 'api.'.
     */
    include_route_files(__DIR__ . '/api/');
});
