<?php

namespace App\Core;

use Firebase\JWT\JWT;

class HttpService {

    static function cors() 
	{
		if (isset($_SERVER['HTTP_ORIGIN'])) {
			header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
			header('Access-Control-Allow-Credentials: true');
			header('Access-Control-Max-Age: 86400'); // cache for 1 day
		}
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {			
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
				header("Access-Control-Allow-Methods: GET, POST, OPTIONS");			
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
				header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");		
			exit(0);
		}
	}

	static function json() 
	{
		header('Content-type: application/json; charset=utf-8');
	}

	static function request()
	{
		parse_str(file_get_contents("php://input"), $data);
		return $data;
	}		

    public function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    public function getBearerToken() 
	{
		$headers = $this->getAuthorizationHeader();
		if (!empty($headers)) {
			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
				return $matches[1];
			}
		}
		return null;
	}

    public function verifyAuthToken()
	{		
		if ($this->getBearerToken()) {
			try {
				$token = JWT::decode($this->getBearerToken(), SECRET, array('HS256'));
			} catch (\Throwable $th) {
				$token = false;
			}
			if ($token) {
				return json_encode([
					"status"=>200,
					"data"=>$token
				]);
			}else {
				echo json_encode([
					"status"=>401,
					"message"=>"Invalid authorization token!"
				]);				
				exit;
			}			
		}else {
			echo json_encode([
				"status"=>401,
				"message"=>"You are not logged in!"
			]);	
			exit;
		}
	}

}