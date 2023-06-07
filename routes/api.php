<?php


use App\Http\Controllers\Api\ {
    AdController,
    AuthController,
    BannerController,
    CategoryController,
    FeatureController,
    MainAdController,
    PackageController,
    ReelController,
    StoryController,
    SubCategoryController,
    UserController,
    VendorController,
};


use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::post('login', [AuthController::class,'login']);
Route::post('register', [AuthController::class,'register']);
Route::post('sign-up', [AuthController::class,'generateOTP']);

Route::group(['middleware' => ['auth:sanctum']], function () {

Route::post('logout', [AuthController::class,'logout']);



Route::post('verify-otp', [AuthController::class,'verifyOTP']);
Route::post('reset-password', [AuthController::class,'resetPassword']);
Route::get('profile', [AuthController::class,'userProfile']);



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

Route::post('make-review', [ReviewController::class,'makeRealestateReview']);
Route::post('delete-review', [ReviewController::class,'deleteRealestateReview']);
Route::get('vendor-reviews', [ReviewController::class,'RealestateReviews']);
Route::post('review-change-status', [ReviewController::class,'statusChange']);

Route::get('categoryAds', [AdController::class,'index']);
Route::get('categoryAd',  [AdController::class,'show']);
Route::post('categoryAd-store',    [AdController::class,'store']);
Route::post('categoryAd-update',   [AdController::class,'update']);
Route::delete('categoryAd-delete', [AdController::class,'destroy']);
Route::post('categoryAd-update-status',   [AdController::class, 'updateStatus']);
Route::post('categoryAd-click-increment', [AdController::class, 'clickIncrement']);

Route::get('banners', [BannerController::class,'index']);
Route::get('banner',  [BannerController::class,'show']);
Route::post('banner-store',    [BannerController::class,'store']);
Route::post('banner-update',   [BannerController::class,'update']);
Route::delete('banner-delete', [BannerController::class,'destroy']);
Route::post('banner-update-status',   [BannerController::class, 'updateStatus']);



Route::get('reels', [ReelController::class,'index']);
Route::get('reel',  [ReelController::class,'show']);
Route::post('reel-store',    [ReelController::class,'store']);
Route::post('reel-update',   [ReelController::class,'update']);
Route::post('reel-delete',   [ReelController::class,'destroy']);

Route::get('mainAds', [MainAdController::class,'index']);
Route::get('mainAd',  [MainAdController::class,'show']);
Route::post('mainAd-store',    [MainAdController::class,'store']);
Route::post('mainAd-update',   [MainAdController::class,'update']);
Route::delete('mainAd-delete', [MainAdController::class,'destroy']);
Route::post('mainAd-update-status',   [MainAdController::class, 'updateStatus']);
Route::post('mainAd-click-increment', [MainAdController::class, 'clickIncrement']);



Route::post('add-favorite-vendor',    [UserController::class, 'addVendorToFavorite']);
Route::post('remove-favorite-vendor', [UserController::class, 'removeVendorToFavorite']);
Route::get('get-favorite-vendors',    [UserController::class, 'getFavoriteVendors']);

Route::post('nearby-vendors', [UserController::class, 'getNearbyVendors']);
});
