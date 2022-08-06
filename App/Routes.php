<?php

use App\Core\Application;

$app = new Application();

$app->get('/', function($req, $res) {
    $res->json(['title'=>'Simple CRUD PHP']);
});

$app->post('/auth', 'AuthController@auth');
$app->post('/user', 'UserController@store');

$app->group('/user', function() use($app) {
    $app->get('', 'UserController@index');
    $app->get('/:id', 'UserController@find');    
    $app->put('/:id', 'UserController@update');
    $app->delete('/:id', 'UserController@destroy');
}, 'AuthMiddleware@index');

$app->group('/month', function() use($app) {
    $app->get('', 'MonthController@index');
    $app->get('/:id', 'MonthController@find');
    $app->post('', 'MonthController@store');
    $app->put('/:id', 'MonthController@update');
    $app->delete('/:id', 'MonthController@destroy');
}, 'AuthMiddleware@index');

$app->group('/expense', function() use($app) {
    $app->get('', 'ExpenseController@index');
    $app->get('/:id', 'ExpenseController@find');
    $app->post('', 'ExpenseController@store');
    $app->put('/:id', 'ExpenseController@update');
    $app->delete('/:id', 'ExpenseController@destroy');
}, 'AuthMiddleware@index');
    
$app->run();
