<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'product_id', 'amount', 'status'
    ];

    public function product()
    {
        return $this->belongsTo('App\Model\Product', 'product_id');
    }

    protected $table = 'discount';
}
