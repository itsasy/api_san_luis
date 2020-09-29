<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_gps extends Model
{
    public $timestamps = false;
    protected $fillable = ['direccion', 'lat', 'lon'];
}
