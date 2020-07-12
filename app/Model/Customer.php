<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'provinsi', 'kota', 'alamat', 'level', 'image'
    ];

    public function orders()
    {
        return $this->hasMany('App\Model\Transaction');
    }

    protected $table = 'customers';
}
