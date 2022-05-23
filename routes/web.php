<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarcodeController;


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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('barcodes', function () {
//     return $products = Product::select('barcode')->get();
//     return view('products.barcode.index');
// })->name('all.barcode');

// Route::Get('barcode', 'App\Http\Controllers\BarcodeController@Barcode')->name('all.barcode');
Route::get('/barcode', [BarcodeController::class, 'Barcode'])->name('all.barcode');

Route::get('/{vue_capture?}',function () {
    return view('welcome');
})->where('vue_capture', '[\/\w\.-]*');








