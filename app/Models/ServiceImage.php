<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceImage extends Model
{

    protected $table = 'services_images';
    public $timestamps = true;
    protected $guarded = array();

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

}
