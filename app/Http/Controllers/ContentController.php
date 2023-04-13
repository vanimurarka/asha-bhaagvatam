<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Book;
use App\Chapter;
use App\ChapterText;
use Log;

class ContentController extends Controller
{
    // public function list()
    // {
    //     return view('user.profile', ['user' => User::findOrFail($id)]);
    // }

    public function addChapters(Request $request)
    {
    	$data = $request->all();
    	$data['nameS'] = '';
    	$chapter = Book::find($data['book_id'])->chapters()->orderBy('order','desc')->first();
    	if ($chapter)
    		$lastOrder = $chapter->order;
    	else
    		$lastOrder = 0;
    	for ($i=1; $i <= $data['chapters']; $i++) { 
    		$data['order'] = $lastOrder + $i;
    		$data['nameE'] = $data['order'];
    		$newChapter = Chapter::create($data);
        	$newChapter->save();
    	}

        return redirect()->route('add-content');
    }

    public function importChapters(Request $request)
    {
        $data = $request->all();
        $filePath = base_path('content/'.$data['filename']);
        Log::info($filePath);
        Log::info(\File::exists($filePath));
        $content = File::get($filePath);
        dd($content);
        $collection = (new FastExcel)->sheet($data['sheet'])->import($filePath);
        // dd($collection);
        $chapter = Chapter::where("book_id",$data["book_id"])
                        ->where("nameE",$data['chapter'])
                        ->first();
        $chapterid = $chapter->id;
        foreach ($collection as $row) {
            // dd($row);
            $text = new ChapterText;
            $text->chapterId = $chapterid;
            $text->type = $row['Type'];
            $text->number = $row['No'];
            $text->lineNumber = $row['SNo'];
            $text->text1 = $row['Sanskrit'];
            if (strlen($row['English'])>0)
                $text->text2 = $row['English'];
            else
                $text->text2 = "";
            try {
                $text->save();
            } catch (\Exception $e) {
                $chapterTextToDelete = ChapterText::where("chapterId",$chapterid);
                $chapterTextToDelete->delete();
                echo "deleted inserted records of chapterid ".$chapterid."<br>";
                echo $e;
                
                break;
            }            
        }
        echo "done";                    
    }
}
