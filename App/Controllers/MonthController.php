<?php

namespace App\Controllers;

use App\Core\ControllerService;
use App\Core\SqlService;

class MonthController extends ControllerService {

    private static $monthModel;

    public function __construct()
    {
        self::$monthModel = new SqlService("month");
    }

    public function index($req, $res) {
        $result = self::$monthModel->select("*");
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
