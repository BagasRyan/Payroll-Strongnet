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

Route::GET('/', 'dashboardController@index')->name('dashboard');

// Auth Controller
Route::get('/login', 'authController@index')->name('login');
Route::post('/loginStore', 'authController@login')->name('login.store');
Route::post('/logout', 'authController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function(){
    // Karyawan Controller
    Route::get('/karyawan', 'KaryawanController@index')->name('karyawan.index');
    Route::get('/karyawan/create', 'KaryawanController@create')->name('karyawan.create');
    Route::post('/karyawan/store', 'KaryawanController@store')->name('karyawan.store');
    Route::post('/karyawan/update', 'KaryawanController@update')->name('karyawan.update');
    Route::get('/karyawan/edit/{id}', 'KaryawanController@edit')->name('karyawan.edit');
    Route::post('/karyawan/delete/{id}', 'KaryawanController@delete')->name('karyawan.delete');

    // Divisi Controller
    Route::get('/divisi', 'DivisiController@index')->name('divisi.index');
    Route::get('/divisi/create', 'DivisiController@create')->name('divisi.create');
    Route::post('/divisi/store', 'DivisiController@store')->name('divisi.store');
    Route::get('/divisi/edit/{id}', 'DivisiController@edit')->name('divisi.edit');
    Route::post('/divisi/update', 'DivisiController@update')->name('divisi.update');
    Route::post('/divisi/delete/{id}', 'DivisiController@delete')->name('divisi.delete');

    //Gaji Bulanan Controller
    Route::get('/gajiBulanan', 'GajiBulananController@index')->name('gaji.bulanan.index');
    Route::get('/gajiBulanan/createTanggal', 'GajiBulananController@createTanggal')->name('gaji.bulanan.create.tanggal');
    Route::post('/gajiBulanan/storeTanggal', 'GajiBulananController@storeTanggal')->name('gaji.bulanan.store.tanggal');
    Route::get('/gajiBulanan/detail/{idTanggal}', 'GajiBulananController@detail')->name('gaji.bulanan.detail');
    Route::get('/gajiBulanan/createGaji/{idTanggal}', 'GajiBulananController@create')->name('gaji.bulanan.create');
    Route::post('/gajiBulanan/store', 'GajiBulananController@store')->name('gaji.bulanan.store');
});