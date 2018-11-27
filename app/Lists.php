<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    protected $table = 'lists';
  

    public function getTasks()
    {
        return $this->hasMany('App\Tasks');
    }
}
