<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FbToken extends Model
{
    protected $fillable = [
        'user_id','fb_token',
    ];
}
