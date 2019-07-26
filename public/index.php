<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!function_exists('getallheaders'))  {
    function getallheaders()
    {
        if (!is_array($_SERVER)) {
            return array();
        }

        $headers = array();
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}

$serverRoot = dirname(__DIR__);
$settings = require_once($serverRoot . '/api/settings.php');
require_once($serverRoot . '/autoload.php');

$request = new \Magnus\Core\Requests();
$path = $request->getPath($_SERVER['REQUEST_URI']);

$context = new \Magnus\Core\Context();
$context->settings = $settings;
$context->serverRoot = $serverRoot;
$context->request = $request;
$context->path = $path;

$root = new \Home\RootController();

$router = new \Magnus\Core\Router();
foreach ($router($root, $path) as list($previous, $obj, $isEndpoint)) {
    if ($isEndpoint) { break; }
}

$dispatch = new \Magnus\Core\Dispatch();
$result = $dispatch($previous, $obj);

echo var_export($result, true);