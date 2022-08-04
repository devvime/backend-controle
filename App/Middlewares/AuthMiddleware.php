<?php

namespace App\Middlewares;

use App\Core\HttpService;

class AuthMiddleware {

    public function index()
    {
        $httpService = new HttpService;
        $httpService->verifyAuthToken();
    }

}