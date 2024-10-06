<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

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


Route::get('/users', function () {
    $users = User::all();
    // return view('users', compact('users'));
    dd($users);
});