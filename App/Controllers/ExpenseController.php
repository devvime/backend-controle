<?php

namespace App\Controllers;

use App\Core\ControllerService;
use App\Core\SqlService;

class ExpenseController extends ControllerService {

    private static $expensesModel;

    public function __construct()
    {
        self::$expensesModel = new SqlService("expenses");
    }

    public function index($req, $res) {
        $result = self::$expensesModel->select("*");
        $res->json([
            "status"=>200,
            "data"=>$result
        ]);
    }

    public function find($req, $res)
    {        
        if (isset($req->query) && isset($req->query->monthId)) {
            $result = self::$expensesModel->select("*", "WHERE monthId = {$req->query->monthId}");
        } else {
            $result = self::$expensesModel->select("*", "WHERE id = {$req->params->id}");
        }        
        $res->json([
            "staus"=>200,
            "data"=>$result
        ]);
    }

    public function store($req, $res) {
        $result = self::$expensesModel->create($req->body);
        if ($result) {
            $this->index($req, $res);
        }
    }

    public function update($req, $res) {
        $this->validate($req->params->id, "required");
        $result = self::$expensesModel->update($req->body, "WHERE id = {$req->params->id}");
        if ($result) {
            $this->index($req, $res);
        }
    }

    public function destroy($req, $res) {
        $this->validate($req->params->id, "required");
        $result = self::$expensesModel->destroy($req->params->id);
        if ($result) {
            $this->index($req, $res);
        }
    }
}
