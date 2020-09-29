<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_persons extends Model
{
    public $table = 'tb_persons';
    
    public function info_user()
    {
        return $this->belongsTo('App\Models\tb_users', 'code_pers', 'code_user');
    }

}
