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

Route::resource('/','IndexController', [
    'only'=>['index'],
    'names'=>[
        'index'=>'home'
    ]
]);

Route::resource('portfolios','PortfolioController', [
                                                        'parameters' => [
                                                            'portfolios' =>'alias'
                                                        ]
                                                    ]);

Route::resource('articles','ArticlesController', [
                                                        'parameters' => [
                                                            'articles' =>'alias'
                                                        ]
                                                    ]);

Route::get('articles/cat/{cat_alias?}','ArticlesController@index')->where('cat_alias', '[\w-]+')->name('articlesCat');

Route::resource('comment','CommentController', [ 'only' => ['store'] ]);


Route::match(['get', 'post'], 'contacts', 'ContactController@index')->name('contacts');


Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');

Route::post('login', 'Auth\LoginController@login');

Route::get('logout', 'Auth\LoginController@logout')->name('logout');

//Auth::routes();

Route::middleware(['auth'])->prefix('admin')->namespace('Admin')->group(function() {

    Route::get('/', ['uses'=>'IndexController@index', 'as'=>'dashboard']);

    Route::resource('/article', 'ArticlesController');

    Route::resource('/permissions', 'PermissionsController');

    Route::resource('/menu', 'MenuController');

    Route::resource('/users', 'UsersController');

    Route::resource('/portfolio', 'PortfolioController');

    Route::resource('/contact', 'ContactsController');

    Route::resource('/slider', 'SliderController');

    Route::resource('/category', 'CategoryController');

    Route::resource('/filter', 'FilterController');


});


