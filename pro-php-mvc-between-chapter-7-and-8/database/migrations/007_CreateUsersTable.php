<?php

use Framework\Database\Connection\Connection;

class CreateUsersTable
{
    public function migrate(Connection $connection)
    {
        $table = $connection->createTable('users');
        $table->id('id');
        $table->string('name');
        $table->string('email');
        $table->string('password');
        $table->execute();
    }
}
