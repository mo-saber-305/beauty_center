<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $table = 'services';
    public $timestamps = true;
    protected $guarded = [];

    /************************************************************************************************************************/

    //relations methods
    public function subCategory()
    {
        return $this->belongsTo('App\Models\SubCategory');
    }

    public function fields()
    {
        return $this->belongsToMany('App\Models\Field');
    }

    public function images()
    {
        return $this->hasMany(ServiceImage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
