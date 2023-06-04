<?php
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SubCategoryController;
use App\Http\Controllers\Api\VendorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('categories',[CategoryController::class,'index']);
Route::get('category',[CategoryController::class,'find']);
Route::post('category_add',[CategoryController::class,'store']);
Route::post('category_update',[CategoryController::class,'update']);
Route::post('category_delete',[CategoryController::class,'destroy']);
Route::post('category_status',[CategoryController::class,'changeStatus']);

Route::get('subcategories',[SubCategoryController::class,'index']);
Route::get('subcategory',[SubCategoryController::class,'find']);
Route::post('subcategory_add',[SubCategoryController::class,'store']);
Route::post('subcategory_update',[SubCategoryController::class,'update']);
Route::post('subcategory_delete',[SubCategoryController::class,'destroy']);

Route::get('vendors',[VendorController::class,'index']);
Route::get('vendor',[VendorController::class,'show']);
Route::post('vendor_add',[VendorController::class,'store']);
Route::post('vendor_update',[VendorController::class,'update']);
Route::post('vendor_delete',[VendorController::class,'destroy']);
Route::post('vendor_status',[VendorController::class,'changeStatus']);
Route::get('vendor_by_category',[VendorController::class,'getCategoryVendors']);

