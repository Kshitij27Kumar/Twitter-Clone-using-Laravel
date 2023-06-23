<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FollowingController;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

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

// Route::get('/', [ProjectController::class,'getData'] );

// Route::get('/',function(){
//     return view('index');
// });
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::post('/submit_tweet', [ProjectController::class, 'submit_tweet'])->name('submit_tweet');



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

Route::get('/', [ProjectController::class,'index'])->name('index')->middleware('auth');


Auth::routes();

Route::middleware('auth')->group(function(){

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/submit_tweet',[ProjectController::class,'submit_tweet'])->name('submit_tweet');

Route::get('/lists',[ProjectController::class,'lists'])->name('lists');

Route::get('/profile/{id}',[ProfileController::class,'profile'])->name('profile');

Route::post('/follow_user',[FollowingController::class,'follow_user'])->name('follow_user');

Route::post('/followings',[FollowingController::class,'followings'])->name('followings');

Route::post('/unfollow_user',[FollowingController::class,'unfollow_user'])->name('unfollow_user');

Route::post('/followers',[FollowingController::class,'followers'])->name('followers');

Route::get('/like_post/{tweet_id}/{user_id}',[ProjectController::class,'like_post'])->name('like_post');

Route::post('/upload_image',[ProfileController::class,'upload_image'])->name('upload_image');



Route::get('/notifications',[ProjectController::class,'notifications'])->name('notifications');

Route::post('/change_username',[ProfileController::class,'change_username'])->name('change_username');


});



// Route::get("test",[ProjectController::class,'test'])->name('test');
// Route::get('/test1/{id1}/{id2}',[ProjectController::class,'test1'])->name('test1');
