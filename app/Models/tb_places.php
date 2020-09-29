<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_places extends Model
{
    public $timestamps = false;

    protected $fillable = ['name_place', 'latitude_place', 'length_place', 'type_place', 'RUC', 'address_place'];
}
