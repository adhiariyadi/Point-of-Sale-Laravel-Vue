<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $fillable = [
        'name', 'nomor', 'code', 'slug', 'category_id', 'description', 'price', 'stock', 'image'
    ];

    public function discount()
    {
        return $this->hasOne('App\Model\Discount');
    }

    public function category()
    {
        return $this->belongsTo('App\Model\Category');
    }

    protected $table = "products";
}
