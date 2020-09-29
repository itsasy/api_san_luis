<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_gender extends Model
{
    public $timestamps = false;
    protected $table = 'tb_gender';
    protected $fillable = ['desc'];
}
