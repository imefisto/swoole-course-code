<?php

use Swoole\HTTP\Server;
use Swoole\HTTP\Request;
use Swoole\HTTP\Response;

$server = new Server("0.0.0.0", 9501);

$server->on("start", function (Server $server) {
    echo "Swoole server is started at http://0.0.0.0:9501\n";
});

$server->on("request", function (Request $request, Response $response) {
    $response->header("Content-Type", "text/plain");
    $response->end("Hello World from Swoole!");
});

$server->start();
