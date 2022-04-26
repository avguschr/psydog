<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
    $router->put('/refresh', 'AuthController@refresh');
    $router->get('/user', ['middleware' => 'auth', 'uses' => 'AuthController@user']);
    $router->delete('/logout', ['middleware' => 'auth', 'uses' => 'AuthController@logout']);
});

$router->group(['prefix' => 'admin', 'middleware' => ['auth', 'can:1']], function () use ($router) {
    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->post('', 'Admin\UserController@create');
        $router->get('', 'Admin\UserController@findAll');
        $router->get('/{id}', 'Admin\UserController@findOne');
        $router->post('/{id}', 'Admin\UserController@update');
        $router->delete('/{id}', 'Admin\UserController@delete');
    });
    $router->group(['prefix' => 'news'], function () use ($router) {
        $router->post('', 'Admin\NewsController@create');
        $router->patch('/{id}', 'Admin\NewsController@update');
        $router->delete('/{id}', 'Admin\NewsController@delete');
    });
    $router->group(['prefix' => 'type'], function () use ($router) {
        $router->post('', 'Admin\TypeController@create');
        $router->patch('/{id}', 'Admin\TypeController@update');
        $router->delete('/{id}', 'Admin\TypeController@delete');
    });
    $router->group(['prefix' => 'service'], function () use ($router) {
        $router->post('', 'Admin\ServiceController@create');
        $router->post('/{id}', 'Admin\ServiceController@update');
        $router->delete('/{id}', 'Admin\ServiceController@delete');
    });
    $router->group(['prefix' => 'lesson'], function () use ($router) {
        $router->post('', 'Admin\LessonController@create');
        $router->patch('/{id}', 'Admin\LessonController@update');
        $router->delete('/{id}', 'Admin\LessonController@delete');
    });
});

$router->group(['prefix' => 'user'], function () use ($router) {
    $router->group(['prefix' => 'news'], function () use ($router) {
        $router->get('', 'User\NewsController@findAll');
        $router->get('/{id}', 'User\NewsController@findOne');
    });
    $router->group(['prefix' => 'lesson'], function () use ($router) {
        $router->get('', 'User\LessonController@findAll');
        $router->get('/{id}', 'User\LessonController@findOne');
    });
});
