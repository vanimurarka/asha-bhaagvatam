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
    return view('welcome',['books' => $books]);
});

Route::get('/chapter/{chapterid}', function ($chapterid) {
	$lines = App\ChapterText::where('chapterId',$chapterid)
				->orderBy("number")
				->orderBy("type")
				->orderBy("lineNumber")->get();
    return view('chapter',['lines' => $lines]);
})->name('chapter');

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
