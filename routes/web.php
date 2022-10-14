<?php

use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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
//Show all listings
Route::get('/', [ListingController::class, 'index']);
//Show Listing create form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');
//Store listings
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');
//Show Listing Edit Form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');
//Update listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');
//Delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');
//Manage listing
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');
//show single listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);
//Show Register Create Form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');
//Create New User
Route::post('/users', [UserController::class, 'store']);
//log User Out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');
//Show login Form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');
//Login Users
Route::post('/users/authenticate', [UserController::class, 'authenticate']);




