<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{

    public $timestamps = false;

    public function category_good()
    {

        return $this->hasManyThrough(Good::class, Category::class, 'id', 'category_good')->first();

    }

}
