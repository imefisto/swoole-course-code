<?php

require_once 'UserController.php';

use Swoole\HTTP\Server;
use Swoole\HTTP\Request;
use Swoole\HTTP\Response;

$server = new Server("0.0.0.0", 9501);
$userController = new UserController;

$server->on("start", function (Server $server) {
    echo "Swoole server is started at http://0.0.0.0:9501\n";
});

$server->on("request", function (Request $request, Response $response) use ($userController) {
    if (strpos($request->server['request_uri'], '/users') === 0) {
        $userController->handleRequest($request, $response);
        return;
    }

    $response->status(404);
    $response->end();
});

$server->start();
