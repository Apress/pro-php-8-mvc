<?php

namespace App\Models;

use Framework\Database\Model;

class Profile extends Model
{
    protected string $table = 'profiles';

    public function user(): mixed
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
