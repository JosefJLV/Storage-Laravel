<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\brandsDataController;
use App\Http\Controllers\expenseDataController;
use App\Http\Controllers\productDataController;
use App\Http\Controllers\clientsDataController;
use App\Http\Controllers\userDataController;
use App\Http\Controllers\orderDataController;
use App\Http\Controllers\staffDataController;
use App\Http\Controllers\docDataController;
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

    
    Route::get('brand-list', [brandsDataController::class, 'index'])->name('brand-list');
    Route::post('add-brand', [brandsDataController::class, 'store'])->name('add-brand');
    Route::post('edit-brand', [brandsDataController::class, 'edit'])->name('edit-brand');
    Route::post('delete-brand', [brandsDataController::class, 'destroy'])->name('delete-brand'); 

    
    Route::get('expense-list', [expenseDataController::class, 'index'])->name('expense-list');
    Route::post('add-expense', [expenseDataController::class, 'store'])->name('add-expense');
    Route::post('edit-expense', [expenseDataController::class, 'edit'])->name('edit-expense');
    Route::post('delete-expense', [expenseDataController::class, 'destroy'])->name('delete-expense');

    Route::get('product-list', [productDataController::class, 'index'])->name('product-list');
    Route::post('add-product', [productDataController::class, 'store'])->name('add-product');
    Route::post('edit-product', [productDataController::class, 'edit'])->name('edit-product');
    Route::post('delete-product', [productDataController::class, 'destroy'])->name('delete-product');

    Route::get('client-list', [clientsDataController::class, 'index'])->name('client-list');
    Route::post('add-client', [clientsDataController::class, 'store'])->name('add-client');
    Route::post('edit-client', [clientsDataController::class, 'edit'])->name('edit-client');
    Route::post('delete-client', [clientsDataController::class, 'destroy'])->name('delete-client');

    Route::get('user-list', [userDataController::class, 'index'])->name('user-list');
    Route::post('add-user', [userDataController::class, 'store'])->name('add-user');
    Route::post('edit-user', [userDataController::class, 'edit'])->name('edit-user');
    Route::post('delete-user', [userDataController::class, 'destroy'])->name('delete-user');
    Route::post('block-user', [userDataController::class, 'block'])->name('block-user');
    Route::post('unblock-user', [userDataController::class, 'unblock'])->name('unblock-user');

    Route::get('order-list', [orderDataController::class, 'index'])->name('order-list');
    Route::post('add-order', [orderDataController::class, 'store'])->name('add-order');
    Route::post('edit-order', [orderDataController::class, 'edit'])->name('edit-order');
    Route::post('delete-order', [orderDataController::class, 'destroy'])->name('delete-order');
    Route::post('confirm-order', [orderDataController::class, 'tesdiq'])->name('confirm-order');
    Route::post('cancel-order', [orderDataController::class, 'cancel'])->name('cancel-order');

    Route::get('staff-list', [staffDataController::class, 'index'])->name('staff-list');
    Route::post('add-staff', [staffDataController::class, 'store']);
    Route::post('edit-staff', [staffDataController::class, 'edit']);
    Route::post('delete-staff', [staffDataController::class, 'destroy']);

    Route::get('doc-list/{id}', [docDataController::class, 'document'])->name('doc-list');
    Route::post('add-doc', [docDataController::class, 'store'])->name('docadd');
    Route::get('edit-doc/{id}', [docDataController::class, 'edit'])->name('doc-edit');
    Route::post('update-doc', [docDataController::class, 'update'])->name('doc-update');
    Route::get('/sil-doc/{id}', [docDataController::class, 'delete'])->name('del-form');
    Route::get('/delete-doc/{id}', [docDataController::class, 'sil'])->name('doc-del');








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

    Route::get('/staff','App\Http\Controllers\staffController@staff')->name('staff');
    Route::post('/sadd','App\Http\Controllers\staffController@add')->name('sadd');
    Route::get('/sedit/{id}','App\Http\Controllers\staffController@edit')->name('sedit');
    Route::post('/supdate','App\Http\Controllers\staffController@update')->name('supdate');
    Route::get('/sdelete/{id}','App\Http\Controllers\staffController@delete')->name('sdelete');
    Route::get('/ssil/{id}','App\Http\Controllers\staffController@sil')->name('ssil');
    Route::get('/staff/documents/{id}','App\Http\Controllers\staffController@document')->name('document');
    Route::post('/docadd','App\Http\Controllers\staffController@docadd');



    Route::get('/users','App\Http\Controllers\usersController@list')->name('users');
    Route::post('/uadd','App\Http\Controllers\usersController@add')->name('uadd');
    Route::get('/block/{id}','App\Http\Controllers\usersController@block')->name('block');
    Route::get('/unblock/{id}','App\Http\Controllers\usersController@unblock')->name('unblock');
    Route::get('/udelete/{id}','App\Http\Controllers\usersController@delete')->name('udelete');
    Route::get('/usil/{id}','App\Http\Controllers\usersController@sil')->name('usil');
    Route::get('/uedit/{id}','App\Http\Controllers\usersController@edit')->name('uedit');
    Route::post('/uupdate','App\Http\Controllers\usersController@update')->name('uupdate');


});

Route::group(['middleware'=>'islogin'], function(){
    Route::post('/register','App\Http\Controllers\registerController@register')->name('register');
    Route::get('/register', function () {return view('register');})->name('registration');

    Route::get('/login', function () {return view('login');})->name('login');
    Route::post('/login','App\Http\Controllers\loginController@login')->name('check');

});
