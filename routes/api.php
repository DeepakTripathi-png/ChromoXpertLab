<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AppConfigController;
use App\Http\Controllers\API\ShopOwner\Auth\LoginController;
use App\Http\Controllers\API\ShopOwner\CommonController;
use App\Http\Controllers\API\ShopOwner\ShopOwnerProfileController;
use App\Http\Controllers\API\ShopOwner\CategoryAndProductsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::get('unauthorized-user', function(){
//     return response()->json(['status' => 401,'message' => 'unauthorized user'], 401);
// })->name('unauthorized-user');

// // dynamic app url
// Route::post('app-base-url', [AppConfigController::class, 'fun_app_get_base_url']);

// // check if mobile no exist
// Route::post('lsm-shop-owner-mobile-number-exists',[LoginController::class, 'shop_owner_mobile_number_exists']);

// // register-mobile-number
// Route::post('lsm-shop-owner-register-mobile-number',[LoginController::class, 'shop_owner_register_mobile_number']);

// // get country list
// Route::get('lsm-country-list',[CommonController::class, 'get_country_list']);

// // get state list
// Route::post('lsm-state-list',[CommonController::class, 'get_states_list']);

// // get city list
// Route::post('lsm-city-list',[CommonController::class, 'get_cities_list']);

// // get city list
// Route::post('lsm-area-list',[CommonController::class, 'get_area_list']);

// // shop owner register
// Route::post('lsm-shop-owner-register', [LoginController::class, 'shop_owner_register']);

// // submit shop owner kyc
// Route::post('lsm-shop-owner-login', [LoginController::class, 'shop_owner_login']);

// Route::middleware('auth:sanctum')->group( function () {
    
//     // submit shop owner kyc
//     Route::post('lsm-shop-owner-kyc-submit', [LoginController::class, 'shop_owner_kyc_submit']);
    
//     // get subscriptions list
//     Route::get('lsm-shop-owner-get-subscriptions-list', [CommonController::class, 'shop_owner_get_subscriptions_list']);
    
//     // shop owner buy subscription
//     Route::post('lsm-shop-owner-buy-subscription', [CommonController::class, 'shop_owner_buy_subscription']);
    
//     // get shop owner account details
//     Route::get('lsm-shop-owner-get-account-details', [ShopOwnerProfileController::class, 'shop_owner_get_account_details']);
    
//     // update shop owner account details
//     Route::post('lsm-shop-owner-update-account-details', [ShopOwnerProfileController::class, 'shop_owner_update_account_details']);
    
//     // get configuration details of shop owner
//     Route::get('lsm-shop-owner-get-configuration-details', [ShopOwnerProfileController::class, 'shop_owner_get_configuration_details']);
    
//     // update configuration details of shop owner
//     Route::post('lsm-shop-owner-update-configuration-details', [ShopOwnerProfileController::class, 'shop_owner_update_configuration_details']);
    
//     // get category list
//     Route::get('lsm-shop-owner-get-category-list', [CategoryAndProductsController::class, 'shop_owner_get_category_list']);
    
//     // add category for shop owner
//     Route::post('lsm-shop-owner-add-category', [CategoryAndProductsController::class, 'shop_owner_add_category']);
    
//     // get selected category of shop owner
//     Route::get('lsm-shop-owner-get-selected-categories', [CategoryAndProductsController::class, 'shop_owner_get_selected_categories']);
    
//     // get products of categories shop owner
//     Route::post('lsm-shop-owner-products-list', [CategoryAndProductsController::class, 'shop_owner_get_products_list']);
    
//     // add products of categories for shop owner
//     Route::post('lsm-shop-owner-add-product-of-category', [CategoryAndProductsController::class, 'shop_owner_add_product_of_category']);

//     // edit products of categories for shop owner
//     Route::post('lsm-shop-owner-edit-product-of-category', [CategoryAndProductsController::class, 'shop_owner_edit_product_of_category']);

//     // update products of categories for shop owner
//     Route::post('lsm-shop-owner-update-product-of-category', [CategoryAndProductsController::class, 'shop_owner_update_product_of_category']);

//     // delete products of categories for shop owner
//     Route::post('lsm-shop-owner-delete-product-of-category', [CategoryAndProductsController::class, 'shop_owner_delete_product_of_category']);
    
//     // get selected products of shop owner
//     Route::post('lsm-shop-owner-get-selected-products', [CategoryAndProductsController::class, 'shop_owner_get_selected_products']);

//     // create custom product for shop owner
//     Route::get('lsm-shop-owner-create_custom_product', [CategoryAndProductsController::class, 'shop_owner_create_custom_product']);
    
//     // add custom product for shop owner
//     Route::post('lsm-shop-owner-add-custom-product', [CategoryAndProductsController::class, 'shop_owner_add_custom_product']);

//     // edit custom product for shop owner
//     Route::post('lsm-shop-owner-edit-custom-product', [CategoryAndProductsController::class, 'shop_owner_edit_custom_product']);

//     // update custom product for shop owner
//     Route::post('lsm-shop-owner-update-custom-product', [CategoryAndProductsController::class, 'shop_owner_update_custom_product']);

//     // delete custom product for shop owner
//     Route::post('lsm-shop-owner-delete-custom-product', [CategoryAndProductsController::class, 'shop_owner_delete_custom_product']);
    
// });
