<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(["middleware" => ["auth"]], function(){
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/anggota',          "AnggotaController@index");
    Route::post('/anggota',         "AnggotaController@store");
    Route::get('/anggota/{id}',     "AnggotaController@show");
    Route::put('/anggota/{id}',     "AnggotaController@update");
    Route::delete('/anggota/{id}',  "AnggotaController@destroy");

    // transaksi
    Route::get('/transaksi',            "TransaksiController@index");
    Route::post('/transaksi/nabung',     "TransaksiController@nabung");
    Route::post('/transaksi/tarik',      "TransaksiController@tarik");

    // pinjam
});
