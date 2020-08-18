<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $table = 'chapters';
    public function book()
    {
        return $this->belongsTo('App\Book','book_id');
    }
}
