<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EditedChapterText extends Model
{
    protected $table = 'edited_chaptertext';

    public function chapterText()
    {
        return $this->belongsTo('App\ChapterText','originalId');
    }

    public static function addEdit($data,$userid)
    {
        // get edited record if it already exits for this
        // user and this originalId
        $editedChapterText = self::where('userid',$userid)
                        ->where('originalId',$data['id'])
                        ->first();
        if (!$editedChapterText) // if none exits create a new one
            $editedChapterText = new EditedChapterText;
            
    	$editedChapterText->userid = $userid;
    	$editedChapterText->originalId = $data['id'];
        $editedChapterText->chapterid = $data['chapterid'];
    	$editedChapterText->text1 = $data['txt1'];
    	if (strlen($data['txt2'])>0)
    		$editedChapterText->text2 = $data['txt2'];
        else
            $editedChapterText->text2 = '';
    	$editedChapterText->save();
    }
}
