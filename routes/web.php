<?php

use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth:web']], function (){
    Route::resource('/mod', 'ModeratorController');
    Route::resource('/profil', 'profilController');
});

Route::get('/', function () {
    return Redirect('home');
});

Route::resource('/room', 'roomController');

Route::get('track','trackController@index')->name('trackHome');
Route::post('track','trackController@tracking')->name('trackNumber');

Route::prefix('admin')->group(function(){
    Route::get('/login', 'admin\LoginnController@showLoginnForm')->name('admin.login');
    Route::post('/login', 'admin\LoginnController@login')->name('admin.login.submit');
    Route::get('/', 'adminController@index')->name('admin.home');

   Route::get('/mod','adminController@showMod')->name('admin.mod.show');
   Route::delete('mod/{id}', 'adminController@destMod')->name('admin.mod.room.remove');;
   Route::post('mod/{id}', 'adminController@addMod')->name('admin.mod.room.add');;

   // attendee Routes
   Route::get('/att','adminController@showAtt')->name('admin.att.show');
   Route::post('/att','adminController@addUserRoom')->name('admin.att.room.add');
   Route::delete('/att','adminController@removeUserRoom')->name('admin.att.room.remove');
});
Route::get('carrier','trackController@carrier')->name('carrier');
 

    


