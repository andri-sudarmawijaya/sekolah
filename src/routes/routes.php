<?php

Route::group(['prefix' => 'api/sekolah', 'middleware' => ['web']], function() {
    $controllers = (object) [
        'index'     => 'Bantenprov\Sekolah\Http\Controllers\SekolahController@index',
        'create'    => 'Bantenprov\Sekolah\Http\Controllers\SekolahController@create',
        'show'      => 'Bantenprov\Sekolah\Http\Controllers\SekolahController@show',
        'store'     => 'Bantenprov\Sekolah\Http\Controllers\SekolahController@store',
        'edit'      => 'Bantenprov\Sekolah\Http\Controllers\SekolahController@edit',
        'update'    => 'Bantenprov\Sekolah\Http\Controllers\SekolahController@update',
        'destroy'   => 'Bantenprov\Sekolah\Http\Controllers\SekolahController@destroy',
    ];

    Route::get('/',             $controllers->index)->name('sekolah.index');
    Route::get('/create',       $controllers->create)->name('sekolah.create');
    Route::get('/{id}',         $controllers->show)->name('sekolah.show');
    Route::post('/',            $controllers->store)->name('sekolah.store');
    Route::get('/{id}/edit',    $controllers->edit)->name('sekolah.edit');
    Route::put('/{id}',         $controllers->update)->name('sekolah.update');
    Route::delete('/{id}',      $controllers->destroy)->name('sekolah.destroy');
});
