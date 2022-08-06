<?php

use App\Core\Application;
use App\Middlewares\AuthMiddleware;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\MonthControler;
use App\Controllers\ExpenseController;

$app = new Application();

$authMiddleware = new AuthMiddleware;
$authController = new AuthController();
$user = new UserController();
$month = new MonthControler();
$expense = new ExpenseController();

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
