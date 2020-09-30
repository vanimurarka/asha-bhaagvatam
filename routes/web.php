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

	$edits = null;
	if (Auth::check())
	{
		$user = Auth::user();
		if ($user->level > 1) // user can suggest edits
		// retrieve pending edits by user
		$edits = App\EditedChapterText::where('chapterid',$chapterid)
				->where('userid',$user->id)
				->orderBy("originalId")->get();
	}
	

	// return $lines->toJson(JSON_UNESCAPED_UNICODE);
    return view('chapter',['lines' => $lines,'chapter'=>$chapter,'booksJson'=>$booksJson,'lastChapter'=>$lastChapter, 'edits'=>$edits]);
	// return view('chapter',['lines' => $lines]);
})->name('chapter');

Route::get('login/google', 'Auth\LoginController@redirectToProvider')->name('googleLogin');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');

Route::post('edit-chapter', function (Illuminate\Http\Request $request) {
	$data = $request->all();
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
})->middleware('auth');

Route::get('manage-edits', function () {
	$users = App\User::withCount(['edits' => function (Illuminate\Database\Eloquent\Builder $query) {
		    $query->where('status', '=', 0);
		}])->get();
	return view('manage-edits',['users'=>$users]);
})->middleware('masteruser')->name('manage-edits');

Route::get('manage-edits/user/{userid}', function ($userid) {
	$user = App\User::find($userid);
	$edits = App\EditedChapterText::where('userid',$userid)
				->where('status',0)
				->with('chapterText')
				->orderBy("originalId")->get();
	return view('manage-edits-user',['user'=>$user,'edits'=>$edits]);
})->middleware('masteruser')->name('manage-edits-user');

Route::post('accept-edit', function (Illuminate\Http\Request $request) {
	$data = $request->all();
	$edit = App\EditedChapterText::find($data['id']);
	$edit->accept();
	return response()->json(array('msg'=> "yes"), 200);
})->middleware('masteruser');

Route::post('reject-edit', function (Illuminate\Http\Request $request) {
	$data = $request->all();
	$edit = App\EditedChapterText::find($data['id']);
	$edit->reject();
	return response()->json(array('msg'=> "yes"), 200);
})->middleware('masteruser');

Route::get('add-content', function () {
	$books = App\Book::get();
	return view('add-content',['books'=>$books]);
})->middleware('auth')->name('add-content');

Route::post('add-book', array('as' => 'add-book', 'uses' => 'BookController@add'))->middleware('auth');

Route::post('add-chapters', array('as' => 'add-chapters', 'uses' => 'ContentController@addChapters'))->middleware('auth');

Route::post('import-chapter', array('as' => 'import-chapter', 'uses' => 'ContentController@importChapters'))->middleware('auth');

Auth::routes(['register' => false]);

Route::get('logout', function () {
    Auth::logout();
    return redirect('/');
});

Route::get('privacy-policy', function () {
    return view('privacy-policy');
});

Route::get('/home', 'HomeController@index')->name('home');
