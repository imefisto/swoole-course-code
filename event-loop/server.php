<?php

// Create a Server object listening on 0.0.0.0:9501.
$server = new Swoole\Server('0.0.0.0', 9501);

// Listen for the 'Connect' event.
$server->on('Connect', function ($server, $fd) {
    echo "Client connected: {$fd}\n";
});

// Listen for the 'Receive' event.
$server->on('Receive', function ($server, $fd, $reactor_id, $data) {
    echo "Received data from {$fd}: {$data}\n";
    
    $response = "Hello, I received: {$data}";
    
    $server->send($fd, $response);
});

// Listen for the 'Close' event.
$server->on('Close', function ($server, $fd) {
    echo "Client closed: {$fd}\n";
});

// Start the server.
$server->start(); 
