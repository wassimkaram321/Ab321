<?php

use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FeatureController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\StoryController;
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
Route::post('category_featured',[CategoryController::class,'changeFeatured']);

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

Route::get('packages',[PackageController::class,'index']);
Route::get('package',[PackageController::class,'show']);
Route::post('package_add',[PackageController::class,'store']);
Route::post('package_update',[PackageController::class,'update']);
Route::post('package_delete',[PackageController::class,'destroy']);
Route::post('add_vendor_package',[PackageController::class,'addVendorPackage']);
Route::post('add_vendor_features',[PackageController::class,'addVendorFeatures']);

Route::get('features',[FeatureController::class,'index']);
Route::get('feature',[FeatureController::class,'show']);
Route::post('feature_add',[FeatureController::class,'store']);
Route::post('feature_update',[FeatureController::class,'update']);
Route::post('feature_delete',[FeatureController::class,'destroy']);

Route::get('stories',[StoryController::class,'index']);
Route::get('story',[StoryController::class,'show']);
Route::post('story_add',[StoryController::class,'store']);
Route::post('story_update',[StoryController::class,'update']);
Route::post('story_delete',[StoryController::class,'destroy']);
Route::post('seen_stories',[StoryController::class,'seenStories']);

Route::get('categoryAds', [AdController::class,'index']);
Route::get('categoryAd',  [AdController::class,'show']);
Route::post('categoryAd-store',    [AdController::class,'store']);
Route::post('categoryAd-update',   [AdController::class,'update']);
Route::delete('categoryAd-delete', [AdController::class,'destroy']);
Route::post('categoryAd-update-status', [AdController::class, 'updateStatus']);

Route::get('banners', [BannerController::class,'index']);
Route::get('banner',  [BannerController::class,'show']);
Route::post('banner-store',    [BannerController::class,'store']);
Route::post('banner-update',   [BannerController::class,'update']);
Route::delete('banner-delete', [BannerController::class,'destroy']);
Route::post('banner-update-status', [BannerController::class, 'updateStatus']);



