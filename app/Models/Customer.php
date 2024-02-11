<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
        'direction',
        'city',
        'country',
        'zip_code',
        'date_register',
    ];
}

