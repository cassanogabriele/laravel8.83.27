<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\ProductWishlist;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class WishlistController extends Controller
{
    public function listWishlists()
    {
        $userId = Session::get('client.id');

        $successMessage = Session::get('wishlist_success_message');
        Session::forget('wishlist_success_message');

        // Récupérer les noms de listes de souhaits distincts de l'utilisateur connecté
        $wishlists = Wishlist::select('name', 'id')
            ->where('user_id', $userId)
            ->distinct()
            ->orderBy('id')
            ->get();

        return view('client.listWishlists')->with(compact('wishlists', 'successMessage'));
    }

    public function refreshWishlist()
    {
        $userId = Session::get('client.id');

        // Récupérer les noms de listes de souhaits distincts de l'utilisateur connecté
        $wishlists = Wishlist::select('name', 'id')
            ->where('user_id', $userId)
            ->distinct()
            ->orderBy('id')
            ->get();

        // Retourner les données au format JSON
        return response()->json($wishlists);
    }

    public function wishlistInfos(Request $request)
    {
        $userId = Session::get('client.id');
        
        $results = Wishlist::select('wishlists.name', 'wishlists.created_at', 'products.product_name', 'products.product_price', 'products.product_description', 'products.product_image', 'products.shipping_cost', 'categories.category_name', 'product_wishlist.wishlist_id', 'product_wishlist.product_id')
            ->join('product_wishlist', 'wishlists.id', '=', 'product_wishlist.wishlist_id')
            ->join('products', 'products.id', '=', 'product_wishlist.product_id')
            ->join('categories', 'categories.id', '=', 'products.product_category')
            ->where('wishlists.user_id', $userId)
            ->where('wishlists.id', $request->wishlistId)
            ->get();
        
        // Construire le tableau d'informations
        $data = [];

        foreach ($results as $result) {
            $data[] = [
                'wishlistName' => $result->name,
                'creationDate' => $result->created_at,
                'productImage' => $result->product_image,
                'productId' => $result->product_id,
                'productName' => $result->product_name,
                'productPrice' => $result->product_price,
                'productDescription' => $result->product_description,
                'productImage' => $result->product_image,
                'shippingCost' => $result->shipping_cost,
                'categoryName' => $result->category_name,
                'wishlistId' => $result->wishlist_id,
            ];
        }

        return response()->json($data);
    }

    public function addToWishlist(Request $request, $productId)
    {
        if(Session::has('client')){ 
            $userId = Session::get('client.id');

            // Récupérer l'article ajouté à la liste de souhait
            $productAdded = Product::where('id', $productId)->get(); 

            // Récupérer toutes les listes de souhaits de l'utilisateur connecté
            $wishlists = Wishlist::where('user_id', $userId)->get();

            return view('client.wishlist')->with(compact('productAdded', 'wishlists'));           
        } else{
            // Stocker l'id du produit pour la redirection
            Session::put('wishlist_product_id', $productId);
            return redirect('client_login');
        }    
    }

    public function recordWishlist(Request $request)
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);

        // Récupérer l'utilisateur connecté
        $userId = Session::get('client.id');

        // Création d'une nouvelle wishlist
        $wishlist = Wishlist::create([
            'user_id' => $userId,
            'name' => $validatedData['name'],
        ]);

        // Récupérer l'id de la wishlist qui vient d'être enregistrée
        $wishlistId = $wishlist->id;

        // Récupérer le nom de la liste qui vient d'être enregistrée
       // $wishlistName = $validatedData['name'];

        // Création de la liste de souhaits sans ajout de produit (dans la page qui affiche les listes de souhaits)
        if($request->product_id != null){
            // Lier les produits à la wishlist
            $wishlist->products()->attach([$request->product_id => ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]]);
        }        

        // Appeler la méthode listWishlists pour mettre à jour la liste des listes de souhaits
        $wishlists = Wishlist::select('name', 'id')
            ->where('user_id', $userId)
            ->distinct()
            ->orderBy('id')
            ->get();       

        return redirect()->route('list_wishlist')->with(compact('wishlists'))->with('success', 'Le formulaire a été soumis avec succès.');;     
    }

    // Ajouter un produit à une liste de souhaits sélectionnée
    public function addToSelectedWishlist(Request $request)
    {
        $userId = Session::get('client.id');

        $wishlist = $request->wishlistId;

        // Lier le produit à la liste de souhaits
        $wishlist = ProductWishlist::create([
            'product_id' => $request->product_id,
            'wishlist_id' => $request->wishlist_id,
            'created_at' => Carbon::now(), 
            'updated_at' => Carbon::now()
        ]);
        
        if ($wishlist) {
            return response()->json(['success' => true, 'message' => 'L\'article a été ajouté à la liste de souhaits.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Une erreur s\'est produite lors de l\'ajout de l\'article à la liste de souhaits.']);
        }        
    }

    public function deleteWishlist(Request $request)
    {
        // Supprimer la liste de souhaits
        $deleteWishlist = Wishlist::where('id', $request->wishlist_id)->delete();
    
        // Supprimer les produits liés à la liste de souhaits
        $deleteProductWishlist = ProductWishlist::where('wishlist_id', $request->wishlist_id)->delete();
    
        $nbItemsWishlist = Wishlist::count(); // Nombre total de listes de souhaits restantes
    
        if ($deleteWishlist > 0) {
            return response()->json([
                'success' => true,
                'message' => "La liste de souhaits : $request->wishlist_name a été supprimée avec succès.",
                // Passer le nombre de listes de souhaits restantes
                'nbItemsWishlist' => $nbItemsWishlist 
            ]);
        } else {
            // Aucune ligne supprimée
            return response()->json([
                'success' => false,
                'message' => "Aucune liste de souhaits : $request->wishlist_name n'a été trouvée",
                'nbItemsWishlist' => $nbItemsWishlist 
            ]);
        }
    }    

    public function deleteProduct(Request $request)
    {              
        $deleteProductWishlist = ProductWishlist::where('wishlist_id', $request->wishlistId)
            ->where('product_id', $request->productId)
            ->delete();        

        if ($deleteProductWishlist > 0) {
            return response()->json([
                'success' => true,
                'message' => "Le produit : $request->productName a été supprimée de la liste.",
            ]);
        } else {
            // Aucune ligne supprimée
            return response()->json([
                'success' => false,
                'message' => "Aucune produit : $request->productName n'a été trouvé dans la liste de souhaits",
            ]);
        }
    }   
}
