<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_users extends Model
{
    protected $table = 'tb_users';
    protected $fillable = ['code_user', 'password_user'];
}
