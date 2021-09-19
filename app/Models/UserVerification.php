<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVerification extends Model
{
    protected $table = 'user_verifications';

    protected $guarded = [];

    protected $hidden = ['code'];

    public $timestamps = false;
}
