<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_alerts extends Model
{
    public $timestamps = false;

    protected $table = 'tb_alerts';


    public function info_user()
    {
        return $this->belongsTo('App\Models\tb_persons', 'code_user_alert', 'code_pers');
    }
}