<?php

namespace App\Controllers;

use App\Core\ControllerService;
use App\Core\SqlService;
use Firebase\JWT\JWT;

class UserController extends ControllerService {

    private static $usersModel;

    public function __construct()
    {
        self::$usersModel = new SqlService('users');        
    }

    public function index($request, $response, $args) {
        self::$usersModel->paginate();
        $result = self::$usersModel->select('id, name, email'); 
        echo json_encode([
            "status"=>200,
            "data"=>$result
        ]);
    }

    public function find($req, $res)
    {
        $result = self::$usersModel->select('id, name, email', "WHERE id = {$req->params->id}");
        $res->json([
            "staus"=>200,
            "data"=>$result
        ]);
    }

    public function store($req, $res) {
        $existUser = self::$usersModel->select('id, name, email', "WHERE email = '{$req->body->email}'");
        if (count($existUser) > 0) {
            $res->json([
                "status"=>"400",
                "message"=>"This user is already registered!"
            ]);
            exit;
        }                
        $this->validate($req->body->name, 'required');
        $this->validate($req->body->email, 'required');
        $this->validate($req->body->email, 'isEmail');
        $this->validate($req->body->password, 'required');        
        $req->body->password = JWT::encode($req->body->password, SECRET);                
        $result = self::$usersModel->create($req->body);
        if ($result) {
            $this->index($req, $res);
        }
    }

    public function update($req, $res) {
        $this->validate($req->params->id, 'required');
        $result = self::$usersModel->update($req->body, "WHERE id = {$req->params->id}");
        if ($result) {
            $this->index($req, $res);
        }
    }

    public function destroy($req, $res) {
        $this->validate($req->params->id, 'required');
        $result = self::$usersModel->destroy($req->params->id);
        if ($result) {
            $this->index($req, $res);
        }
    }
}
