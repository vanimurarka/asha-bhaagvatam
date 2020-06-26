<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    public function chapters()
    {
        return $this->hasMany('App\Chapter');
    }
}
