<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FieldService extends Pivot
{

    protected $table = 'field_service';
    public $timestamps = true;
    protected $guarded = array();
}
