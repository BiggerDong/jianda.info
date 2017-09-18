<?php

use Illuminate\Routing\Router;

Admin::registerHelpersRoutes();

Route::group([
    'prefix'        => config('admin.prefix'),
    'namespace'     => Admin::controllerNamespace(),
    'middleware'    => ['web', 'admin'],
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->get('/users/{id}/edit', 'UsersController@edit');
    $router->get('/users', 'UsersController@index');
    $router->get('/questions/{id}/edit', 'QuestionsController@edit');
    $router->get('/questions/warnings', 'QuestionsController@warning');
    $router->get('/questions/', 'QuestionsController@index');

});
