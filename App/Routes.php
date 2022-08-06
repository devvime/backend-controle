<?php

use App\Middlewares\AuthMiddleware;
use App\Controllers\UserController;

$app = new \Slim\App;
$authMiddleware = new AuthMiddleware;

$app->get('/', function($req, $res) {
    $res->json(['title'=>'Simple CRUD PHP', 'root'=>$_SERVER['DOCUMENT_ROOT']]);
});

$app->post('/user', 'UserController@store');
$app->post('/auth', 'AuthController@auth');

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

$app->group('', function($app) {
    $app->get('/user', UserController::class . ':index');
    // $app->get('/:id', 'UserController@find');    
    // $app->put('/:id', 'UserController@update');
    // $app->delete('/:id', 'UserController@destroy');
});

$app->run();
