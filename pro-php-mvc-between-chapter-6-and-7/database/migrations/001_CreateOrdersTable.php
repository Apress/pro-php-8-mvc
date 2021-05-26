<?php

use Framework\Database\Connection\Connection;

class CreateOrdersTable
{
    public function migrate(Connection $connection)
    {
        $table = $connection->createTable('orders');
        $table->id('id');
        $table->int('quantity')->default(1);
        $table->float('price')->nullable();
        $table->bool('is_confirmed')->default(false);
        $table->dateTime('ordered_at')->default('CURRENT_TIMESTAMP');
        $table->text('notes');
        $table->execute();
    }
}
