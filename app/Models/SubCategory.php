<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{

    protected $table = 'sub_categories';
    public $timestamps = true;
    protected $guarded = array('category_id', 'name', 'image');

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function services()
    {
        return $this->hasMany('App\Models\Service');
    }

    public function fields()
    {
        return $this->belongsToMany('App\Models\Field');
    }

}
