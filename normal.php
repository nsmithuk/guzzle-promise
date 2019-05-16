<?php
include_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

$requests = [];

for ($i = 1; $i <= 20; $i++) {
    $requests["A0000{$i}"] = new Request('GET', 'http://slowwly.robertomurray.co.uk/delay/1000/url/http://www.google.co.uk');
}

//----------------------------------------------

$client = new Client();

foreach ($requests as $id=>$request) {
    $client->send($request);
    echo "We have a result for: $id\n";
}
