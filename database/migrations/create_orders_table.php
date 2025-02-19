<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;

require __DIR__ . '/../../bootstrap.php';

try {
    Capsule::schema()->create('sergey_isaykin', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('order_id')->unique()->comment('Идентификатор заказа');
        $table->unsignedBigInteger('customer_id')->comment('Идентификатор клиента');
        $table->string('order_number')->comment('Номер заказа');
        $table->timestamp('order_date')->nullable()->comment('Факт. дата поступления заказа');
        $table->date('date_of_sale')->nullable()->comment('Дата продажи');
        $table->decimal('sum', 10, 2)->default(0)->comment('Сумма заказа');
        $table->decimal('prepay_sum', 10, 2)->default(0)->comment('Оплаченная сумма');
        $table->timestamps();
    });
} catch (QueryException $e) {
    if ($e->getCode() === '42S01') {
        dump('Table `sergey_isaykin` already exists. Skipping table creation.');
    } else {
        $logger->error('Error while creating table: ' . $e->getMessage());
    }
}