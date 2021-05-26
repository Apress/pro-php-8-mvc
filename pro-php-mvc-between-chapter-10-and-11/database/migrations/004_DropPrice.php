<?php

use Framework\Database\Connection\Connection;

class DropPrice
{
    public function migrate(Connection $connection)
    {
        $table = $connection->alterTable('orders');
        $table->dropColumn('price');
        $table->execute();
    }
}
