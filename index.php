<?php

use App\Http\OrderFetcher;

require __DIR__ . '/bootstrap.php';

$apiService = new OrderFetcher($logger);
$apiService->fetchAndStore();