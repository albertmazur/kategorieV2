<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

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
/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', [CategoryController::class, "view"])->name("home");

Route::post('/', [CategoryController::class, "view"]);

Route::delete('/remove', [CategoryController::class, "remove"]);

Route::put('/add', [CategoryController::class, "add"]);

Route::post('/viewChildren', [CategoryController::class, "viewChildren"]);
