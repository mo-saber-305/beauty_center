<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model 
{

    protected $table = 'sections';
    public $timestamps = true;
    protected $guarded = array('name');

    public function categories()
    {
        return $this->hasMany('App\Models\Category');
    }

}