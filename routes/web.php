<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

	$books = App\Book::with('chapters')->get();
	$json = $books->toJson();
    return view('index',['json' => $json]);
    // return view('welcome',['books' => $books]);
})->name('index');

Route::get('/chapter/{chapterid}', function ($chapterid) {
	$lines = App\ChapterText::where('chapterId',$chapterid)
				->orderBy("number")
				->orderBy("type")
				->orderBy("lineNumber")->get();
	$chapter = App\Chapter::where('id',$chapterid)
					->with('book')
					->first();
	$books = App\Book::with('chapters')->get();
	$booksJson = $books->toJson();
	$lastChapter = false;
	$nBooks = count($books);
	$nChaptersInLastBook = count($books[$nBooks-1]->chapters);
	$lastChapterId = $books[$nBooks-1]->chapters[$nChaptersInLastBook-1]->id;
	if ($lastChapterId == $chapterid)
		$lastChapter = true;
	// return $lines->toJson(JSON_UNESCAPED_UNICODE);
    return view('chapter',['lines' => $lines,'chapter'=>$chapter,'booksJson'=>$booksJson,'lastChapter'=>$lastChapter]);
	// return view('chapter',['lines' => $lines]);
})->name('chapter');

Route::get('login/google', 'Auth\LoginController@redirectToProvider')->name('googleLogin');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');

Route::post('edit-chapter', function (Illuminate\Http\Request $request) {
	$data = $request->all();
	Log::debug($data);
	$user = Auth::user();
	if ($user->level == 1) // change text on server
	{
		$dbText = App\ChapterText::where('id',$data['id'])->first();
		$dbText->edit($data);
	}
	if ($user->level == 2) // record change in edit table
	{
		App\EditedChapterText::addEdit($data,$user->id);
	}
	return response()->json(array('msg'=> "yes"), 200);
});

Auth::routes(['register' => false]);

Route::get('logout', function () {
    Auth::logout();
    return redirect('/');
});

Route::get('privacy-policy', function () {
    return view('privacy-policy');
});

Route::get('/home', 'HomeController@index')->name('home');
