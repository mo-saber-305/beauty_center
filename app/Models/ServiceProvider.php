<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model 
{

    protected $table = 'service_providers';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}