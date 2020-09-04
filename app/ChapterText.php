<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChapterText extends Model
{
    protected $table = 'chaptertext';

    public function edit($data)
    {
    	$this->text1 = $data['txt1'];
    	if (strlen($data['txt2'])>0)
    		$this->text2 = $data['txt2'];
    	$this->save();
    }
}
