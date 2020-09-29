<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_evacuationspoints extends Model
{
    public $timestamps = false;
    protected $fillable = ['name_place', 'latitude_place', 'length_place', 'address_place', 'img'];
}
