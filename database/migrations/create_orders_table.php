<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

require __DIR__ . '/../../bootstrap.php';

Capsule::schema()->create('sergey_isaykin', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('order_id')->unique();
    $table->unsignedBigInteger('customer_id');
    $table->string('order_number');
    $table->date('order_date');
    $table->date('date_of_sale');
    $table->float('sum');
    $table->float('prepay_sum');
    $table->timestamps();
});