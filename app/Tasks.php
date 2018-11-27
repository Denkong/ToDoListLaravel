<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $fillable = ['list_id', 'name'];
    protected $table = 'tasks';

    public function getLists()
    {
        return $this->belongsTo('App\Lists','lists_id');
    }
}
