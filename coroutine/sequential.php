<?php
// sequential.php
$urls = [
    "https://httpbin.org/delay/3",
    "https://httpbin.org/delay/2",
    "https://httpbin.org/delay/1",
];

$overallStart = microtime(true);

foreach ($urls as $url) {
    $start = microtime(true);
    $data = file_get_contents($url);
    $elapsed = round(microtime(true) - $start, 2);
    echo "Finished $url in {$elapsed}s\n";
}

$elapsed = microtime(true) - $overallStart;
echo "Finished all urls in {$elapsed}s\n";
