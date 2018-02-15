<?php

Route::group(['prefix' => 'sekolah', 'middleware' => ['web']], function() {

    $controllers = (object) [
        'index'     => 'Bantenprov\Sekolah\Http\Controllers\SekolahController@index',
        'create'     => 'Bantenprov\Sekolah\Http\Controllers\SekolahController@create',
        'store'     => 'Bantenprov\Sekolah\Http\Controllers\SekolahController@store',
        'show'      => 'Bantenprov\Sekolah\Http\Controllers\SekolahController@show',
        'update'    => 'Bantenprov\Sekolah\Http\Controllers\SekolahController@update',
        'destroy'   => 'Bantenprov\Sekolah\Http\Controllers\SekolahController@destroy',
    ];

    Route::get('/',$controllers->index)->name('sekolah.index');
    Route::get('/create',$controllers->create)->name('sekolah.create');
    Route::post('/store',$controllers->store)->name('sekolah.store');
    Route::get('/{id}',$controllers->show)->name('sekolah.show');
    Route::put('/{id}/update',$controllers->update)->name('sekolah.update');
    Route::post('/{id}/delete',$controllers->destroy)->name('sekolah.destroy');

});

