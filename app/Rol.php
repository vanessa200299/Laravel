<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';

    public function post()
    {
        return $this->belongsTo('App\User');
    }
}
