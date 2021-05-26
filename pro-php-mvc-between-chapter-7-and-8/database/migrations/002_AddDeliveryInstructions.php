<?php

use Framework\Database\Connection\Connection;

class AddDeliveryInstructions
{
    public function migrate(Connection $connection)
    {
        $table = $connection->alterTable('orders');
        $table->text('delivery_instructions');
        $table->execute();
    }
}
