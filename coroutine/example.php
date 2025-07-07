<?php
use Swoole\Coroutine\WaitGroup;

Co\run(function () {
    $urls = [
        "https://httpbin.org/delay/2",
        "https://httpbin.org/delay/1",
        "https://httpbin.org/delay/3",
    ];

    $wg = new WaitGroup();
    $overallStart = microtime(true);

    foreach ($urls as $url) {
        Co\go(function () use ($url, $wg) {
            $wg->add();
            $start = microtime(true);
            $response = file_get_contents($url);
            $elapsed = microtime(true) - $start;
            echo "Finished $url in {$elapsed}s\n";
            $wg->done();
        });
    }

    $wg->wait();
    $elapsed = microtime(true) - $overallStart;
    echo "Finished all urls in {$elapsed}s\n";
});
