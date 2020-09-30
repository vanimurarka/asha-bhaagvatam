<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class BookController extends Controller
{
    // public function list()
    // {
    //     return view('user.profile', ['user' => User::findOrFail($id)]);
    // }

    public function add(Request $request)
    {
    	$data = $request->all();
    	$data['nameS'] = '';
        $book = Book::create($data);
        $book->save();

        return redirect()->route('add-content');
    }
}
