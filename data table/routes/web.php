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

Route::group(['middleware'=>'notlogin'], function(){
    Route::post('/add','App\Http\Controllers\brandsController@add')->name('brandsadd');
    Route::get('/','App\Http\Controllers\brandsController@list')->name('blist');
    Route::get('/delete/{id}','App\Http\Controllers\brandsController@delete')->name('delete');
    Route::get('/bsil/{id}','App\Http\Controllers\brandsController@sil')->name('bsil');
    Route::get('/edit/{id}','App\Http\Controllers\brandsController@edit')->name('edit');
    Route::post('/update','App\Http\Controllers\brandsController@update')->name('update');



    Route::post('/padd','App\Http\Controllers\productsController@add')->name('productsadd');
    Route::get('/plist','App\Http\Controllers\productsController@list')->name('plist');
    Route::get('/pdelete/{id}','App\Http\Controllers\productsController@delete')->name('pdelete');
    Route::get('/psil/{id}','App\Http\Controllers\productsController@sil')->name('psil');
    Route::get('/pedit/{id}','App\Http\Controllers\productsController@edit')->name('pedit');
    Route::post('/pupdate','App\Http\Controllers\productsController@update')->name('pupdate');


    Route::post('/cadd','App\Http\Controllers\clientsController@add')->name('clientsadd');
    Route::get('/clist','App\Http\Controllers\clientsController@list')->name('clist');
    Route::get('/cdelete/{id}','App\Http\Controllers\clientsController@delete')->name('cdelete');
    Route::get('/csil/{id}','App\Http\Controllers\clientsController@sil')->name('csil');
    Route::get('/cedit/{id}','App\Http\Controllers\clientsController@edit')->name('cedit');
    Route::post('/cupdate','App\Http\Controllers\clientsController@update')->name('cupdate');

    Route::post('/eadd','App\Http\Controllers\expenseController@add')->name('expensesadd');
    Route::get('/elist','App\Http\Controllers\expenseController@list')->name('elist');
    Route::get('/edelete/{id}','App\Http\Controllers\expenseController@delete')->name('edelete');
    Route::get('/esil/{id}','App\Http\Controllers\expenseController@sil')->name('esil');
    Route::get('/eedit/{id}','App\Http\Controllers\expenseController@edit')->name('eedit');
    Route::post('/eupdate','App\Http\Controllers\expenseController@update')->name('eupdate');

    Route::post('/oradd','App\Http\Controllers\ordersController@add')->name('oradd');
    Route::get('/orlist','App\Http\Controllers\ordersController@list')->name('orlist');
    Route::get('/odelete/{id}','App\Http\Controllers\ordersController@delete')->name('odelete');
    Route::get('/oedit/{id}','App\Http\Controllers\ordersController@edit')->name('oedit');
    Route::post('/oupdate','App\Http\Controllers\ordersController@update')->name('oupdate');
    Route::get('/confirm/{id}','App\Http\Controllers\ordersController@confirm')->name('confirm');
    Route::get('/sil/{id}','App\Http\Controllers\ordersController@sil')->name('sil');
    Route::get('/cancel/{id}','App\Http\Controllers\ordersController@cancel')->name('cancel');

    Route::get('/logout','App\Http\Controllers\loginController@logout')->name('exit');
    
    Route::get('/profil','App\Http\Controllers\profileController@profile')->name('profil');
    Route::post('/submit','App\Http\Controllers\profileController@submit')->name('submit');

});

Route::group(['middleware'=>'islogin'], function(){
    Route::post('/register','App\Http\Controllers\registerController@register')->name('register');
    Route::get('/register', function () {return view('register');})->name('registration');

    Route::get('/login', function () {return view('login');})->name('login');
    Route::post('/login','App\Http\Controllers\loginController@login')->name('check');

});
