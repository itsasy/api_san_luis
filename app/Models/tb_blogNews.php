<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_blogNews extends Model
{
    protected $table = 'tb_news';
    protected $fillable = [ 'author','title','description','source','url','img'];
}
