<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_municipal_services extends Model
{
    public $timestamps = false;
    protected $fillable = ['code_munser', 'description_munser'];
}
