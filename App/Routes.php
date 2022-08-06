<?php

use App\Core\Application;
use App\Middlewares\AuthMiddleware;
use App\Controllers\UserController;

$app = new Application();
$authMiddleware = new AuthMiddleware;
$user = new UserController();

$app->get('/', function($req, $res) {
    $res->json(['title'=>'Simple CRUD PHP']);
});

// $app->post('/auth', 'AuthController@auth');

// $app->get('/user', function($req, $res) use($user) {
//     $user->index($req, $res);
// });
$app->get('/user', 'UserController@index');
// $app->get('/user/:id', 'UserController@find');    
// $app->post('/user', 'UserController@store');
// $app->put('/user/:id', 'UserController@update');
// $app->delete('/user/:id', 'UserController@destroy');

// $app->get('/month', 'MonthControler@index', 'AuthMiddleware@index');
// $app->get('/month/:id', 'MonthControler@find', 'AuthMiddleware@index');
// $app->post('/month', 'MonthControler@store', 'AuthMiddleware@index');
// $app->put('/month/:id', 'MonthControler@update', 'AuthMiddleware@index');
// $app->delete('/month/:id', 'MonthControler@destroy', 'AuthMiddleware@index');

// $app->get('/expense', 'ExpenseController@index', 'AuthMiddleware@index');
// $app->get('/expense/:id', 'ExpenseController@find', 'AuthMiddleware@index');
// $app->post('/expense', 'ExpenseController@store', 'AuthMiddleware@index');
// $app->put('/expense/:id', 'ExpenseController@update', 'AuthMiddleware@index');
// $app->delete('/expense/:id', 'ExpenseController@destroy', 'AuthMiddleware@index');
    
$app->run();
