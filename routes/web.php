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
})->name('home');

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

Auth::routes(['register' => false]);

Route::get('privacy-policy', function () {
    return view('privacy-policy');
});

// Route::get('/home', 'HomeController@index');
