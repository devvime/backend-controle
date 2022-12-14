<?php

namespace App\Controllers;

use App\Core\ControllerService;
use App\Core\SqlService;
use App\Core\HttpService;
use Firebase\JWT\JWT;

class MonthController extends ControllerService {

    private static $monthModel;
    private static $httpService;

    public function __construct()
    {
        self::$monthModel = new SqlService("month");
        self::$httpService = new HttpService();
    }

    public function index($req, $res) {
        $user_token = self::$httpService->getBearerToken();
        $userData = JWT::decode($user_token, SECRET, ['HS256']);
        $result = self::$monthModel->select("*", "WHERE userId = {$userData->id} order by id desc");
        $res->json([
            "status"=>200,
            "data"=>$result
        ]);
    }

    public function find($req, $res)
    {
        $result = self::$monthModel->select("*", "WHERE id = {$req->params->id}");
        $res->json([
            "staus"=>200,
            "data"=>$result
        ]);
    }

    public function store($req, $res) {
        $result = self::$monthModel->create($req->body);
        if ($result) {
            $this->index($req, $res);
        }
    }

    public function update($req, $res) {
        $this->validate($req->params->id, "required");
        $result = self::$monthModel->update($req->body, "WHERE id = {$req->params->id}");
        if ($result) {
            $this->index($req, $res);
        }
    }

    public function destroy($req, $res) {
        $this->validate($req->params->id, "required");
        $result = self::$monthModel->destroy($req->params->id);
        if ($result) {
            $this->index($req, $res);
        }
    }
}
