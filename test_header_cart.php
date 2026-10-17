<?php

$urls = [
    '/' => 'Home',
    '/dichvu' => 'Services',
    '/banggia' => 'Price List',
    '/contact' => 'Contact',
    '/tintuc' => 'News',
    '/san-pham/may-lanh-inverter-toshiba-ras-h13e2kcvg-v' => 'Product Detail',
    '/carts' => 'Cart Page',
];

$ctx = stream_context_create(['http' => ['ignore_errors' => true]]);

foreach ($urls as $path => $name) {
    $url = "http://127.0.0.1:8000$path";
    $html = @file_get_contents($url, false, $ctx);
    $status = 'UNKNOWN';
    if (isset($http_response_header) && isset($http_response_header[0])) {
        $status = $http_response_header[0];
    }
    $hasHeader = strpos($html, 'react-header-root') !== false;
    $hasHeaderData = strpos($html, 'header-initial-data') !== false;
    $hasCart = strpos($html, 'react-cart-root') !== false;
    $hasCartData = strpos($html, 'cart-initial-data') !== false;
    $hasErr = (stripos($html, 'Fatal error') !== false || stripos($html, 'ErrorException') !== false);

    echo "[$status] $name ($path)\n";
    echo "  - Header Root: " . ($hasHeader ? 'YES' : 'NO') . " | Header Data: " . ($hasHeaderData ? 'YES' : 'NO') . "\n";
    if ($path === '/carts') {
        echo "  - Cart Root: " . ($hasCart ? 'YES' : 'NO') . " | Cart Data: " . ($hasCartData ? 'YES' : 'NO') . "\n";
    }
    echo "  - Error: " . ($hasErr ? 'FAIL' : 'PASS') . "\n\n";
}
