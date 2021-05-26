<?php

use Framework\Database\Connection\Connection;

class CreateProfilesTable
{
    public function migrate(Connection $connection)
    {
        $table = $connection->createTable('profiles');
        $table->id('id');
        $table->int('user_id');
        $table->execute();
    }
}
