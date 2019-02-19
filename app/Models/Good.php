<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{

    public $timestamps = false;

    public function category_good()
    {

        return $this->hasMany(Category::class, 'id', 'category_good')->first();

    }

    public function category_manufacturing()
    {

        return $this->hasMany(Category::class, 'id', 'category_manufacturing')->first();

    }

    public function category_stock()
    {

        return $this->hasMany(Category::class, 'id', 'category_stock')->first();

    }

}
