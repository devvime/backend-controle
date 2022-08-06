<?php

use App\Core\Application;

$app = new Application();

$app->get('/', function($req, $res) {
    $res->json(['title'=>'Simple CRUD PHP']);
});

$app->post('/auth', 'AuthControler@auth');

$app->get('/user', 'UserController@index', 'AuthMiddleware@index');
$app->get('/user/:id', 'UserController@find', 'AuthMiddleware@index');
$app->post('/user', 'UserController@store', 'AuthMiddleware@index');
$app->put('/user/:id', 'UserController@update', 'AuthMiddleware@index');
$app->delete('/user/:id', 'UserController@destroy', 'AuthMiddleware@index');

$app->get('/month', 'MonthControler@index', 'AuthMiddleware@index');
$app->get('/month/:id', 'MonthControler@find', 'AuthMiddleware@index');
$app->post('/month', 'MonthControler@store', 'AuthMiddleware@index');
$app->put('/month/:id', 'MonthControler@update', 'AuthMiddleware@index');
$app->delete('/month/:id', 'MonthControler@destroy', 'AuthMiddleware@index');

$app->get('/expense', 'ExpenseController@index', 'AuthMiddleware@index');
$app->get('/expense/:id', 'ExpenseController@find', 'AuthMiddleware@index');
$app->post('/expense', 'ExpenseController@store', 'AuthMiddleware@index');
$app->put('/expense/:id', 'ExpenseController@update', 'AuthMiddleware@index');
$app->delete('/expense/:id', 'ExpenseController@destroy', 'AuthMiddleware@index');
    
$app->run();
