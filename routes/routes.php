<?php

use Illuminate\Routing\Router;

$attributes = [
    'prefix'     => config('admin.route.prefix'),
    'middleware' => config('admin.route.middleware'),
];

app('router')->group($attributes, function ($router) {

    /* @var \Illuminate\Support\Facades\Route $router */
    $router->namespace('\App\Http\Controllers\Admin')->group(function ($router) {

        /* @var \Illuminate\Routing\Router $router */
        $router->resource('auth/users', 'UserController')->names('admin.auth.users');
        $router->resource('auth/roles', 'RoleController')->names('admin.auth.roles');
        $router->resource('auth/permissions', 'PermissionController')->names('admin.auth.permissions');
        $router->resource('auth/menu', 'MenuController', ['except' => ['create']])->names('admin.auth.menu');
        $router->resource('auth/logs', 'LogController', ['only' => ['index', 'destroy']])->names('admin.auth.logs');

        $router->post('_handle_form_', 'HandleController@handleForm')->name('admin.handle-form');
        $router->post('_handle_action_', 'HandleController@handleAction')->name('admin.handle-action');
    });

    $authController = config('admin.auth.controller', AuthController::class);

    /* @var \Illuminate\Routing\Router $router */
    $router->get('auth/login', $authController.'@getLogin')->name('admin.login');
    $router->post('auth/login', $authController.'@postLogin');
    $router->get('auth/logout', $authController.'@getLogout')->name('admin.logout');
    $router->get('auth/setting', $authController.'@getSetting')->name('admin.setting');
    $router->put('auth/setting', $authController.'@putSetting');
});

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

});
