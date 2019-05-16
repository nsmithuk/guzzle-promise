<?php
    include_once 'vendor/autoload.php';

use GuzzleHttp\Pool;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

$requests = [];

for ($i = 1; $i <= 20; $i++) {
    $requests["A0000{$i}"] = new Request('GET', 'http://slowwly.robertomurray.co.uk/delay/1000/url/http://www.google.co.uk');
}

//----------------------------------------------

$client = new Client();

$results = [];

$pool = new Pool($client, $requests, [
    'concurrency' => 25,
    'fulfilled' => function ($response, $index) use (&$results) {
        echo "We have a result for: $index\n";
        $results[$index] = $response;
    },
    'rejected' => function ($reason, $index){
        echo "$index failed\n";
    },
]);

// Initiate the transfers and create a promise
$promise = $pool->promise();

// Force the pool of requests to complete.
$promise->wait();

// We only get here once all requests have returned.

//-----------------

foreach ($results as $key=>$result) {
    echo "{$key} - ".get_class($result)."\n";
}
