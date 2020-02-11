<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{

    public function categories()
    {
        return $this->hasMany('App\Models\Category', 'domain_id', 'id');
    }
}
