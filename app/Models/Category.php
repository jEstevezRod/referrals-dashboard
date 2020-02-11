<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function domain()
    {
        return $this->belongsTo('App\Models\Domain', 'id', 'domain_id');
    }

    public function products(){
        return $this->hasMany('App\Models\Product', 'cat_id', 'id');
    }
}
