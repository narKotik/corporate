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


/*
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');


*/

/*
Route::resource('/', 'IndexController', [
    'only' => [
        'index',
    ],
    'names' => [
        'index' => 'home',
    ],
]);
*/
Route::get('/', ['uses' => 'IndexController@index', 'as' => 'home']);

Route::resource('portfolios', 'PortfolioController', [
    'parameters' => [
        'portfolios' => 'alias',
    ]
]);
/*
Route::resource('/articles', 'ArticlesController', [
    'parameters' => [
        'articles' => 'alias',
    ]
]);
*/
Route::get('/articles', ['as' => 'articles.main.index', 'uses' => 'ArticlesController@index']);
Route::get('/articles/{alias}', ['as' => 'articles.main.show', 'uses' => 'ArticlesController@show']);


Route::get('/articles/cat/{cat_alias?}', ['uses' => 'ArticlesController@index', 'as' => 'articlesCat'])->where('cat_alias', '\w+');

//Route::resource('comment', 'CommentController', ['only' => ['store']]);
Route::post('comment', ['uses' => 'CommentController@store', 'as' => 'comment.store']);

Route::match(['get', 'post'], '/contacts', ['uses' => 'ContactsController@index', 'as' => 'contacts']);

//Route::auth();
// php artisan make:auth
Route::get('/login', ['uses' => 'Auth\LoginController@showLoginForm', 'as' => 'login']);
Route::post('/login', ['as' => 'loginPost', 'uses' => 'Auth\LoginController@login']);
Route::get('/logout', 'Auth\LoginController@logout');


Route::group(['prefix' => '/admin', 'middleware' => 'auth'], function () {
    Route::get('/', ['uses' => 'Admin\IndexController@index', 'as' => 'adminIndex']);

    Route::resource('/articles', 'Admin\ArticlesController');

    Route::resource('/permitions', 'Admin\PermitionsController');
    Route::resource('/menus', 'Admin\MenusController');
    Route::resource('/users', 'Admin\UsersController');
});