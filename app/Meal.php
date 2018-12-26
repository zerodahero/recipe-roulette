<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meal extends Model
{
    use SoftDeletes;

    protected $fillable = ['day', 'recipe_id'];

    // protected $appends = ['recipes'];

    // public function recipesAttribute()
    // {
    //     return $this->hasMany()
    // }
}
