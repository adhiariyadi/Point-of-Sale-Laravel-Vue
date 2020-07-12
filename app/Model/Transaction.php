<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'invoice', 'user_id', 'total', 'bayar', 'kembalian', 'payment_method', 'customer_id'
    ];

    public function details()
    {
        return $this->hasMany('App\Model\TransactionDetail', 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Model\Customer', 'customer_id');
    }

    public function cashier()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    protected $table = "orders";
}
