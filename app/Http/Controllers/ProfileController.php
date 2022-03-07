<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth")->except(['index', 'detail']);
    }
    public function index()
    {
        $data = Article::latest()->where("user_id", auth()->user()->id)->paginate(5);

        return view("users.profile", [
            "articles" => $data,
        ]);
    }
}
