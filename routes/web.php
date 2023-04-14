<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[BlogController::class,'blogs'])->name('blogs');
Route::post('/blog-filter',[BlogController::class,'allblogs'])->name('allblogs');

Route::get('logout',[AuthController::class,'logout'])->name('admin.logout');
Route::get('admin',[AuthController::class,'index'])->name('admin.login');
Route::post('adminpostlogin', [AuthController::class, 'postLogin'])->name('admin.postlogin');

Route::get('registration', [AuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [AuthController::class, 'customRegistration'])->name('register.custom');

Route::group(['prefix'=>'admin','middleware'=>['auth'],'as'=>'admin.'],function () {
    Route::get('dashboard', [BlogController::class, 'index']);
    Route::get('blogs/list', [BlogController::class, 'getblogs'])->name('blogs.list');

    Route::post('addorupdateblog',[BlogController::class,'addorupdateblog'])->name('blog.addorupdate');
    Route::get('blog/{id}/edit',[BlogController::class,'editblog'])->name('blog.edit');
    Route::get('blog/{id}/delete',[BlogController::class,'deleteblog'])->name('blog.delete');
});