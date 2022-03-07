<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth")->except(['index', 'detail']);
    }
    public function index()
    {
        $data = Article::latest()->paginate(5);

        return view("articles.index", [
            "articles" => $data,
        ]);
    }
    public function add()
    {
        $data = Category::all();
        return view("articles.add", [
            "categories" => $data,
        ]);
    }
    public function create()
    {
        $validator = validator(request()->all(), [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        $article = new Article();
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->user_id = auth()->user()->id;
        $article->save();

        return redirect("/articles")->with('info', "Article added");
    }
    public function detail($id)
    {
        $data = Article::find($id);

        return view("articles.detail", [
            "article" => $data,
        ]);
    }
    public function edit($id)
    {
        $article = Article::find($id);

        if (Gate::denies("article-edit", $article)) {
            return back()->with("error", "Unauthorize");
        }
        $categories = Category::all();

        return view("articles.edit", [
            "article" => $article,
            "categories" => $categories,
        ]);
    }

    public function update()
    {
        $validator = validator(request()->all(), [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $article = Article::find(request()->id);

        if (!$article) {
            return back()->with("error", "Invalid");
        }

        if (Gate::denies("article-update", $article)) {
            return back()->with("error", "Unauthorize");
        }

        $affected = DB::table("articles")
            ->where("id", $article->id)
            ->update(["title" => request()->title, "body" => request()->body, "category_id" => request()->category_id]);

        if (!$affected) {
            return back()->with("error", "Error");
        } 

        return redirect()->route('articles.detail', ['id' => $article->id])->with('info', "Article updated");
    }
    public function delete()
    {
        $id = request()->id;
        $article = Article::find($id);

        if (Gate::denies('article-delete', $article)) {
            return back()->with("error", "Unauthorize");
        }
        $article->delete();

        return redirect("/articles")->with("info", "Article deleted");
    }
}
