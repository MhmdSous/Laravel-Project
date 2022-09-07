<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HomeController;

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
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/', function () {
    $brands=DB::table('brands')->get();
    return view('home',compact('brands'));
});

// Category Controller

Route::middleware(['auth'])->group(function () {
Route::get('/category/all', [CategoryController::class, 'AllCat'])->name('all.category');
Route::post('/category/add', [CategoryController::class, 'AddCat'])->name('store.category');
Route::get('/category/edit/{id}', [CategoryController::class, 'edit']);
Route::post('/category/update/{id}', [CategoryController::class, 'update']);
Route::get('/softdelete/category/{id}', [CategoryController::class, 'softdelete']);
Route::get('/category/restore/{id}', [CategoryController::class, 'restore']);
Route::get('/pdelete/category/{id}', [CategoryController::class, 'pdelete']);

// For Brand
Route::get('/brand/all', [BrandController::class, 'AllBrand'])->name('all.brand');
Route::post('/brand/add', [BrandController::class, 'StoreBrand'])->name('store.brand');
Route::get('/brand/edit/{id}', [BrandController::class, 'edit']);
Route::post('/brand/update/{id}', [BrandController::class, 'update']);
Route::get('/softdelete/brand/{id}', [BrandController::class, 'softdelete']);
// Route::get('/brand/restore/{id}', [CategoryController::class, 'restore']);
// Route::get('/pdelete/brand/{id}', [CategoryController::class, 'pdelete']);

});
//Admin Route
Route::get('/home/slider', [HomeController::class, 'HomeSlider'])->name('home.slider');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        // $users = User::all();
        // ,compact('users')
        return view('admin.index');
    })->name('dashboard');
});
Route::get('/user/logout', [BrandController::class, 'logout'])->name('user.logout');
