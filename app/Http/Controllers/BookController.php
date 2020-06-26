<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function list()
    {
        return view('user.profile', ['user' => User::findOrFail($id)]);
    }
}
