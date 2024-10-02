<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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

// Client
Route::get('/', [App\Http\Controllers\ClientController::class, 'home'])->name('home');
Route::get('/shop', [App\Http\Controllers\ClientController::class, 'shop'])->name('shop');
Route::get('/cart', [App\Http\Controllers\ClientController::class, 'cart'])->name('cart');
Route::get('/nb_item_cart', [App\Http\Controllers\ClientController::class, 'get_nb_items_cart'])->name('nb_item_cart');
Route::get('/client_login', [App\Http\Controllers\ClientController::class, 'client_login'])->name('client_login');
Route::get('/logout', [App\Http\Controllers\ClientController::class, 'logout'])->name('logout');
Route::get('/signup', [App\Http\Controllers\ClientController::class, 'signup'])->name('signup');
Route::get('/payment', [App\Http\Controllers\ClientController::class, 'payment'])->name('payment');
Route::post('/pay', [App\Http\Controllers\ClientController::class, 'pay'])->name('pay');

Route::get('/confirm_order', function () {
    $orders = session('orders');
    return view('client.confirmOrder', compact('orders'));
})->name('confirm_order');

Route::get('/select_by_category/{name}', [App\Http\Controllers\ClientController::class, 'selectByCategory'])->name('select_by_category');

Route::get('/article_by_reference/{reference}', [App\Http\Controllers\ClientController::class, 'articleByReference'])->name('article_by_reference');

// Produits récemment vus 
Route::post('/record_viewed_product', [App\Http\Controllers\RecentlyViewedProductController::class, 'recordViewedProduct'])->name('record_viewed_product');
Route::get('/recently_viewed_product', [App\Http\Controllers\RecentlyViewedProductController::class, 'getRecentlyViewedProduct'])->name('recently_viewed_product');
Route::get('/all_recently_viewed_products', [App\Http\Controllers\RecentlyViewedProductController::class, 'getRecentViewedProducts'])->name('all_recently_viewed_products');

// Dernière commande
Route::get('/last_order', [App\Http\Controllers\OrderController::class, 'getLastOrder'])->name('last_order');
Route::get('/all_orders', [App\Http\Controllers\OrderController::class, 'getAllOrders'])->name('all_orders');

// Panier en db
Route::delete('/remove_product/{id}', [App\Http\Controllers\ClientController::class, 'removeProduct'])->name('remove_product');
Route::post('/modify_qty/{id}', [App\Http\Controllers\ClientController::class, 'modifyQty'])->name('modify_qty');
Route::get('/add_to_cart/{id}', [App\Http\Controllers\ClientController::class, 'addToCart'])->name('add_to_cart');

// Compte client
Route::post('/creer_compte', [App\Http\Controllers\ClientController::class, 'creer_compte'])->name('creer_compte');
Route::post('/acceder_compte', [App\Http\Controllers\ClientController::class, 'acceder_compte'])->name('acceder_compte');
Route::get('/account', [App\Http\Controllers\ClientController::class, 'account'])->name('account');
Route::get('/infos_client', [App\Http\Controllers\ClientController::class, 'getInfosClient'])->name('infos_client');
Route::post('/update_infos_client', [App\Http\Controllers\ClientController::class, 'updateInfosClient'])->name('update_infos_client');
Route::get('/orders', [App\Http\Controllers\ClientController::class, 'getOrders'])->name('order');
Route::post('/order_details', [App\Http\Controllers\ClientController::class, 'getOrdersDetails'])->name('order_details');
Route::post('/cancel_order', [App\Http\Controllers\ClientController::class, 'cancelOrder'])->name('cancel_order');

// Footer
Route::get('/shipping', [App\Http\Controllers\ClientController::class, 'shipping_informations'])->name('shipping.informations');
Route::get('/returns', [App\Http\Controllers\ClientController::class, 'returns_informations'])->name('returns.informations');
Route::get('/conditions', [App\Http\Controllers\ClientController::class, 'conditions_informations'])->name('conditions.informations');
Route::get('/generalconditions', [App\Http\Controllers\ClientController::class, 'general_conditions_informations'])->name('generalconditions.informations');
Route::get('/privacy', [App\Http\Controllers\ClientController::class, 'privacy_informations'])->name('privacy.informations');
Route::get('/legalnotice', [App\Http\Controllers\ClientController::class, 'legal_notice_informations'])->name('legalNotice.informations');

// Wishilist
Route::get('/add_to_wishlist/{id}', [App\Http\Controllers\WishlistController::class, 'addToWishlist'])->name('add_to_wishlist');
Route::get('/add_to_selected_wishlist', [App\Http\Controllers\WishlistController::class, 'addToSelectedWishlist'])->name('add_to_selected_wishlist');
Route::post('/record_wishlist', [App\Http\Controllers\WishlistController::class, 'recordWishlist'])->name('record_wishlist');
Route::post('/delete_wishlist', [App\Http\Controllers\WishlistController::class, 'deleteWishlist'])->name('delete_wishlist');
Route::post('/delete_product', [App\Http\Controllers\WishlistController::class, 'deleteProduct'])->name('delete_product');
Route::get('/list_wishlist', [App\Http\Controllers\WishlistController::class, 'listWishlists'])->name('list_wishlist');
Route::get('/refresh_wishlist', [App\Http\Controllers\WishlistController::class, 'refreshWishlist'])->name('refreshWishlist');
Route::post('/wishlist_infos', [App\Http\Controllers\WishlistController::class, 'wishlistInfos'])->name('wishlist_infos');

// PdfController
Route::get('/voir_pdf/{id}', [App\Http\Controllers\PdfController::class, 'voir_pdf'])->name('voir_pdf');

// Admin
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
Route::get('/commandes', [App\Http\Controllers\AdminController::class, 'commandes'])->name('commandes');

Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'categories'])->name('categories');
Route::get('/ajoutercategorie', [App\Http\Controllers\CategoryController::class, 'ajoutercategorie'])->name('ajoutercategorie');
Route::post('/sauvercategorie', [App\Http\Controllers\CategoryController::class, 'sauvercategorie'])->name('sauvercategorie');
Route::get('/editcategory/{id}', [App\Http\Controllers\CategoryController::class, 'edit_category'])->name('edit_category');
Route::post('/modifiercategorie', [App\Http\Controllers\CategoryController::class, 'modifiercategorie'])->name('modifiercategorie');
Route::get('/deletecategory/{id}', [App\Http\Controllers\CategoryController::class, 'delete_category'])->name('delete_category');

Route::get('/produits', [App\Http\Controllers\ProductController::class, 'produits'])->name('produits');
Route::get('/ajouterproduit', [App\Http\Controllers\ProductController::class, 'ajouterproduit'])->name('ajouterproduit');
Route::post('/sauverproduit', [App\Http\Controllers\ProductController::class, 'sauverproduit'])->name('sauverproduit');
Route::get('/editproduct/{id}', [App\Http\Controllers\ProductController::class, 'edit_product'])->name('edit_product');
Route::post('/modifierproduit', [App\Http\Controllers\ProductController::class, 'modifierproduit'])->name('modifierproduit');
Route::get('/deleteproduct/{id}', [App\Http\Controllers\ProductController::class, 'delete_product'])->name('delete_produit');
Route::get('/activateproduct/{id}', [App\Http\Controllers\ProductController::class, 'activate_product'])->name('activate_product');
Route::get('/deactivateproduct/{id}', [App\Http\Controllers\ProductController::class, 'deactivate_product'])->name('deactivate_product');

Route::get('/sliders', [App\Http\Controllers\SliderController::class, 'sliders'])->name('sliders');
Route::get('/ajouterslider', [App\Http\Controllers\SliderController::class, 'ajouterslider'])->name('ajouterslider');
Route::post('/sauverslider', [App\Http\Controllers\SliderController::class, 'sauverslider'])->name('sauverslider');
Route::get('/editslider/{id}', [App\Http\Controllers\SliderController::class, 'edit_slider'])->name('edit_slider');
Route::get('/deleteslider/{id}', [App\Http\Controllers\SliderController::class, 'delete_slider'])->name('delete_slider');
Route::get('/activateslider/{id}', [App\Http\Controllers\SliderController::class, 'activate_slider'])->name('activate_slider');
Route::get('/deactivateslider/{id}', [App\Http\Controllers\SliderController::class, 'deactivate_slider'])->name('deactivate_slider');
Route::post('/modifierslider/{id}', [App\Http\Controllers\SliderController::class, 'modifierslider'])->name('modifierslider');

Auth::routes();

Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('admin');


