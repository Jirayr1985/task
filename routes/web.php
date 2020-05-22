<?php

use App\Http\Controllers\Conversations\RetrieveConversationsController;
use App\Http\Controllers\Users\RetrieveUsersController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

//Auth::routes();

Route::namespace('App\Http\Controllers')->group(function (){
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');
});


Route::prefix('users')->group(function () {
    Route::get('', RetrieveUsersController::class);
    Route::get('{user}/conversations', RetrieveConversationsController::class)->name('conversations');
});
