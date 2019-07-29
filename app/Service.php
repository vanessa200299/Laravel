<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    protected $fillable = [
        'name', 'status', 'user_id','created_at','updated_at'
    ];
    public function post()
    {
        return $this->belongsTo('App\User');
    }
}
