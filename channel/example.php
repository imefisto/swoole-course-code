<?php
use Swoole\Coroutine\Channel;

Co\run(function () {
    $urls = [
        "url1" => "https://httpbin.org/delay/3",
        "url2" => "https://httpbin.org/delay/2",
        "url3" => "https://httpbin.org/delay/1",
    ];

    $channel = new Channel();
    $overallStart = microtime(true);

    foreach ($urls as $id => $url) {
        Co\go(function () use ($id, $url, $channel) {
            $start = microtime(true);
            $response = file_get_contents($url);
            $elapsed = microtime(true) - $start;
            $channel->push([
                'urlId' => $id,
                'elapsedTime' => $elapsed
            ]);
        });
    }

    for($i = 0; $i < count($urls); $i++) {
        $data = $channel->pop();
        echo "Finished {$urls[$data['urlId']]} in {$data['elapsedTime']}s\n";
    }

    $elapsed = microtime(true) - $overallStart;
    echo "Finished all urls in {$elapsed}s\n";
});
