<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

Route::get('/greet', function () {
    return "Hello World";
});

Route::name('articles.')->prefix('/articles')->group(function () {
    Route::get('', 'ArticleController@index');
    Route::get('/add', 'ArticleController@add')->name("add");
    Route::post('/add', 'ArticleController@create')->name("create");
    Route::get('/edit/{id}', 'ArticleController@edit')->name("edit")->where("id", "[0-9]+");
    Route::post('/update', 'ArticleController@update')->name("update");

    Route::get('/detail/{id}', 'ArticleController@detail')->name("detail")->where("id", "[0-9]+");
    Route::post('/delete', 'ArticleController@delete')->name("delete");
});
Route::get('/', 'ArticleController@index');


Route::get('/products', 'Product\ProductController@index');
Route::get('/categories', 'Category\CategoryController@index');

Route::post('/comments/add', 'CommentController@create')->name("comments.add");
Route::post('/comments/delete', 'CommentController@delete')->name("comments.delete");

Route::get('/users/{id}', 'ProfileController@index')->name("profile")->where("id", "[0-9]+");

Route::any("/test", function (Request $req) {
    if ($req->method() == "POST") {
        return "Hello POST";
    } else if ($req->method() == "GET") {
        return $req->method();
    }
})->name("test-route");

Route::match(["GET", "POST"], "/match", function () {
    return "Match";
})->name("match-route");

Auth::routes();

Route::get('/home', function () {
    return redirect('/');
});

Route::fallback(function () {
    return "fallback";
});