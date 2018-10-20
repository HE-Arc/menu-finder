<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
    'name',
    'active',
    'rate_sum',
    'rate_nb',
    'location',
    'address',
    'zip',
    'city',
    'avatar',
    'description'
    ];
}
