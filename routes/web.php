<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('form', function(){
    $data = request()->all();
    //dd($data);
    return view('form')->with('data',$data);
});

Route::get('/', function(){
    return 'Hello World';
});