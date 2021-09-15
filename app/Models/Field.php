<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{

    protected $table = 'fields';
    public $timestamps = true;
    protected $guarded = array();

    public function services()
    {
        return $this->belongsToMany('App\Models\Service');
    }

    public function subCategories()
    {
        return $this->belongsToMany('App\Models\SubCategory');
    }
}
