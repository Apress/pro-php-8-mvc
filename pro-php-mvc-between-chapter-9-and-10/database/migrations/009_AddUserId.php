<?php

use Framework\Database\Connection\Connection;

class AddUserId
{
    public function migrate(Connection $connection)
    {
        $table = $connection->alterTable('orders');
        $table->int('user_id');
        $table->execute();
    }
}
