<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.index', compact('users'));
    }
    public function search()
    {
        $search_text=$_GET["user-search"];
        $users = User::where('name','LIKE', '%'.$search_text.'%')->get();
    
        return view('admin.search-users',
        compact('users'));
    }

}
