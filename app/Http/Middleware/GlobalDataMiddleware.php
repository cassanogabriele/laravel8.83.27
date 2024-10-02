<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Client;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Wishlist;


class GlobalDataMiddleware
{
    public function __construct()
    {       
        Session::put('key', 'value');
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
              
        // Récupérer la session client
        $client = Session::get('client');

        
        $sliders = Slider::where('status', 1)->get();
        $products = Product::where('status', 1)->get();
        // Pour la page d'accueil 
        $selectedProducts = Product::where('status', 1)->limit(8)->get();
        $clients = Client::orderBy('id', 'asc')->limit(6)->get();
        $randomCategories = Category::inRandomOrder()
                                ->limit(4)
                                ->get();

        $firstCategories = $randomCategories->take(2);
        $remainingCategories = $randomCategories->skip(2)->take(2);
        $randomProducts = Product::where('id', '>', 4)
                                ->inRandomOrder()
                                ->limit(4)
                                ->get();

        $categories = Category::get();

        // Pour avoir le panier partout sur le site
        if ($client) {
            $cart = Cart::where('user_id', $client->id)->get();

            $nbItemsCart = $cart->count();   
            $totalCartWithoutShipping = $cart->sum('total_without_shipping');
            $totalCartWithShipping = $cart->sum('total_with_shipping');
            $totalShipping = $cart->sum('shipping_cost');        
        } else {
            // Récupérer le panier local
            $cartData = session()->get('cart', []);
            $cart = Cart::hydrate($cartData);

            // Nombre d'articles dans le panier local
            $nbItemsCart = count($cart);  
            // Calculer le total du panier local
            $totalCartWithoutShipping = collect($cart)->sum('total_without_shipping');
            $totalCartWithShipping = collect($cart)->sum('total_with_shipping');
            $totalShipping = collect($cart)->sum('shipping_cost');               
        }       

        // Pour avoir la liste de souhaits partout sur le site
        $wishList = Wishlist::all();
        
        $nbItemsWishlist = $wishList->count();

        // Partager les variables avec toutes les vues
        view()->share([
            'sliders' => $sliders,
            'selectedProducts' => $selectedProducts,
            'products' => $products,
            'clients' => $clients,
            'randomProducts' => $randomProducts,
            'categories' => $categories,
            'cart' => $cart,
            'nbItemsCart' => $nbItemsCart,
            'totalCartWithoutShipping' => $totalCartWithoutShipping,
            'totalCartWithShipping' => $totalCartWithShipping,
            'totalShipping' =>  $totalShipping,
            'wishList' => $wishList,
            'nbItemsWishlist' => $nbItemsWishlist,
            'randomCategories' => $randomCategories,
            'firstCategories' => $firstCategories,
            'remainingCategories' => $remainingCategories
        ]);

        return $next($request);
    }
}
