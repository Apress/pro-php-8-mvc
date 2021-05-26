<?php

use Framework\Database\Connection\Connection;

class ChangeQuantity
{
    public function migrate(Connection $connection)
    {
        $table = $connection->alterTable('orders');
        $table->int('quantity')->nullable()->alter();
        $table->execute();
    }
}
