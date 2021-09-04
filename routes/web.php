<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::any('/event', 'EventController@index');
Route::any('/event/ajax_datagrid', 'EventController@ajax_datagrid');
Route::any('/event/add', 'EventController@addEvent');
Route::any('/event/{id}/update', 'EventController@updateEvent');
Route::any('/event/{id}/delete', 'EventController@deleteEvent');
Route::any('/event/{id}/view', 'EventController@viewEvent');
