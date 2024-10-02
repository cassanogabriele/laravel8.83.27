<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\RecentlyViewedProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class RecentlyViewedProductController extends Controller
{
    // Ajouter le produit vu dans la table 
    public function recordViewedProduct(Request $request)
    {
        $productId = $request->input('productId');
        
        // Récupérer les informations du produit
        $product = Product::find($productId);

        if(Session::has('client')){ 
            $userId = Session::get('client.id');

            if ($product) {
                // Créer un nouvel enregistrement dans la table recently_viewed_products
                RecentlyViewedProduct::create([
                    'user_id' => $userId,
                    'product_name' => $product->product_name,
                    'product_price' => $product->product_price,
                    'product_image' => $product->product_image,
                    'shipping_cost' => $product->shipping_cost,
                    'qty' => 1, // Vous pouvez ajuster cette valeur en fonction de vos besoins
                    'product_description' => $product->product_description,
                    'product_category' => $product->product_category,
                    'status' => $product->status,
                ]);
        
                return response()->json(['message' => 'Le produit a été ajouté aux produits récemment consultés.']);
            } else {
                return response()->json(['message' => 'Le produit n\'a pas été trouvé.']);
            }               
        }    
    }

    // Récupérer l'article vue le plus récent
    public function getRecentlyViewedProduct()
    {
        $userId = Session::get('client.id');

        $recentlyViewedProduct = RecentlyViewedProduct::where('user_id', $userId)->latest()->get();
        return $recentlyViewedProduct;
    }    

    public function getRecentViewedArticles()
    {
        $userId = Session::get('client.id');
        $recentlyViewedProducts = RecentlyViewedProduct::where('user_id', $userId)->get();
       
        return view('client.recentlyViewedArticles')->with('recentlyViewedProducts', $recentlyViewedProducts);
    }
}


