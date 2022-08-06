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

$app->post('/auth', function($req, $res) use($authController) {
    $authController->auth($req, $res);
});

$app->get('/month', 'MonthControler@index', 'AuthMiddleware@index');
// $app->get('/month/:id', 'MonthControler@find', 'AuthMiddleware@index');
// $app->post('/month', 'MonthControler@store', 'AuthMiddleware@index');
// $app->put('/month/:id', 'MonthControler@update', 'AuthMiddleware@index');
// $app->delete('/month/:id', 'MonthControler@destroy', 'AuthMiddleware@index');

// $app->get('/expense', 'ExpenseController@index', 'AuthMiddleware@index');
// $app->get('/expense/:id', 'ExpenseController@find', 'AuthMiddleware@index');
// $app->post('/expense', 'ExpenseController@store', 'AuthMiddleware@index');
// $app->put('/expense/:id', 'ExpenseController@update', 'AuthMiddleware@index');
// $app->delete('/expense/:id', 'ExpenseController@destroy', 'AuthMiddleware@index');

$app->group('/user', function() use($app, $user) {
    $app->get('', function($req, $res) use($user) {
        $user->index($req, $res);
    });
    $app->get('/:id', function($req, $res) use($user) {
        $user->find($req, $res);
    });
    $app->post('', function($req, $res) use($user) {
        $user->store($req, $res);
    });
    $app->put('/:id', function($req, $res) use($user) {
        $user->update($req, $res);
    });
    $app->delete('/:id', function($req, $res) use($user) {
        $user->destroy($req, $res);
    });
}, function($req, $res) use($authMiddleware) {
    $authMiddleware->index($req, $res);
});
    
$app->run();
