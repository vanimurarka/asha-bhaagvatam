<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $table = 'chapters';
    protected $fillable = ['order','book_id','nameS','nameE'];

    public function book()
    {
        return $this->belongsTo('App\Book','book_id');
    }
}
