<?php

namespace App\Models;

use Framework\Database\Model;

class Order extends Model
{
    protected string $table = 'orders';

    public function user(): mixed
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
