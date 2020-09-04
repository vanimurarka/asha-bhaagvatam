<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EditedChapterText extends Model
{
    protected $table = 'edited_chaptertext';

    public static function addEdit($data,$userid)
    {
    	$edit = new EditedChapterText;
    	$edit->userid = $userid;
    	$edit->originalId = $data['id'];
    	$edit->text1 = $data['txt1'];
    	if (strlen($data['txt2'])>0)
    		$edit->text2 = $data['txt2'];
    	$edit->save();
    }
}
