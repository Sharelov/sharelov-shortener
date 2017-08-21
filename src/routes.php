<?php

Route::get('/sh/{hash}',[
    'as'=>'shortener.get',
    'uses'=>'Sharelov\Shortener\Controllers\LinksController@translateHash'
]);

Route::post('/sh',[
    'as'=>'shortener.store',
    'uses'=>'Sharelov\Shortener\Controllers\LinksController@store'
]);
