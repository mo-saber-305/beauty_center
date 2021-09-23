<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $table = 'categories';
    public $timestamps = true;
    protected $guarded = array();
    protected $appends = ['image_path'];

    /************************************************************************************************************************/

    // attributes methods
    public function getImagePathAttribute()
    {
        return asset($this->image);
    }

    /************************************************************************************************************************/

    //relations methods
    public function section()
    {
        return $this->belongsTo('App\Models\Section');
    }

    public function subCategories()
    {
        return $this->hasMany('App\Models\SubCategory');
    }

}
