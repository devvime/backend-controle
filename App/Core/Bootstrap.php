<?php

require_once('vendor/autoload.php');
require_once('app/Config/Config.php');

use App\Core\HttpService;

HttpService::json();
HttpService::cors();

require_once('app/Routes.php');
