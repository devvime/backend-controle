<?php

namespace App\Controllers;

use App\Core\ControllerService;
use App\Core\SqlService;
use Firebase\JWT\JWT;

class AuthController extends ControllerService {

    private static $usersModel;
    private static $httpService;

    public function __construct()
    {
        self::$usersModel = new SqlService("users");
    }

    public function auth($req, $res)
    {
        $this->validate($req->body->email, 'required');
        $this->validate($req->body->email, 'isEmail');
        $this->validate($req->body->password, 'required');
        $user = self::$usersModel->select('*', "WHERE email = '{$req->body->email}'");
        if (count($user) === 0) {
            $res->json([
                "status"=>404,
                "message"=>"This user is not found!"
            ]);
            exit;
        }
        $pass = JWT::encode($req->body->password, SECRET);
        if ($pass === $user[0]->password) {
            $token = JWT::encode($user[0], SECRET);
            $res->json([
                "status"=>200,
                "message"=>"Login succesful!",
                "data"=>[
                    "auth_token"=>$token
                ]
            ]);
        } else {
            $res->json([
                "status"=>400,
                "message"=>"Incorrect username or password."
            ]);
            exit;
        }
    }
}
