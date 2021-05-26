<?php

namespace App\Models;

use Framework\Database\TableName;
use Framework\Database\Model;

#[TableName('users')]
class User extends Model
{
    public function profile(): mixed
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function orders(): mixed
    {
        return $this->hasMany(Order::class, 'user_id');
    }
}
