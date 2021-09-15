<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FieldSubCategory extends Pivot
{
    protected $table = 'field_sub_category';
    protected $guarded = [];
}
