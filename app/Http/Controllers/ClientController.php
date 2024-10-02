<?php

namespace App\Http\Controllers;

use App\CartUser;
use Stripe\Charge;
use Stripe\Stripe;
use App\Models\Cart;
use App\Models\Order;
use App\Mail\SendMail;
use App\Models\Product;
use App\Models\Category;
use App\Models\Slider;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ClientController extends Controller
{
    public function __construct()
    {       
        Session::put('key', 'value');
    }
    
    public function home(){    
        return view('client.home');
    }

    public function shop(){      
        $products = Product::where('status', 1)->get();

        return view('client.shop')->with(compact('products'));
    }  

    public function selectByCategory($name)
    {
        $products = Category::where('category_name', $name)
            ->firstOrFail()
            ->products()
            ->where('status', 1)
            ->get();
    
        return view('client.articleByCategory')->with(compact('products', 'name'));
    }

    public function articleByReference($reference)
    {
        $product = Product::find($reference);

        return view('client.articleByReference')->with(compact('product'));
    }

    // Gestion du panier

    public function cart()
    {
        return view('client.cart');
    }   

    public function addToCart($id)
    {
        $product = Product::find($id);
    
        // Vérifier si l'utilisateur est connecté
        if(Session::has('client')){
            $userId = Session::get('client.id');
    
            // Vérifier si l'article est déjà présent dans le panier
            $cartItem = Cart::where('user_id', $userId)
                ->where('product_id', $product->id)
                ->first();
    
            if ($cartItem) {
                // L'article est déjà dans le panier, mettre à jour la quantité
                $cartItem->qty += 1;
                $cartItem->save();
            } else {
                // Ajouter l'article au panier
                Cart::create([
                    'user_id' => $userId,
                    'product_id' => $product->id,
                    'product_name' => $product->product_name,
                    'product_price' => $product->product_price,
                    'product_image' => $product->product_image,
                    'shipping_cost' => ($product->shipping_cost),
                    'qty' => 1,
                    'total_without_shipping' => $product->product_price * 1,
                    'total_with_shipping' => ($product->product_price * 1) + $product->shipping_cost,
                ]);
            }

            // Mettre à jour le nombre d'articles dans le panier
            $nbItemsCart = Cart::count();
        } else {
            // Si l'utilisateur n'est pas connecté, gérer le panier localement
            $cart = session()->get('cart');
    
            // Vérifier si le panier est vide
            if (!$cart) {
                $cart = [];
            }
    
            // Vérifier si l'article est déjà dans le panier
            if (isset($cart[$product->id])) {
                // L'article est déjà dans le panier, mettre à jour la quantité
                $cart[$product->id]['qty'] += 1;
            } else {
                // Ajouter l'article au panier
                $cart[$product->id] = [
                    'product_id' => $product->id,
                    'product_name' => $product->product_name,
                    'product_price' => $product->product_price,
                    'product_image' => $product->product_image,
                    'shipping_cost' => $product->shipping_cost,
                    'qty' => 1,
                    'total_without_shipping' => $product->product_price * 1,
                    'total_with_shipping' => ($product->product_price * 1) + $product->shipping_cost,
                ];
            }
    
            // Mettre à jour le panier local en session
            session()->put('cart', $cart);

            // Mettre à jour le nombre d'articles dans le panier
            $nbItemsCart = count(session()->get('cart', []));
        }           
    
        // Obtenir les produits similaires
        $similarProducts = Product::where('product_category', $product->product_category)
            ->where('id', '!=', $product->id)
            ->limit(5)
            ->get();   
            
        return view('client.confirm')->with(compact('product', 'similarProducts', 'nbItemsCart'));
    }    
   
    public function modifyQty($id, Request $request){
        if(Session::has('client')){ 
            // Panier connecté
            $cart = Cart::find($id);

            // Récuper les frais de livraison du produit 
            $product = Product::find($cart->product_id);   
            $shippingCost = $product->shipping_cost * $request->quantity;     
    
            Cart::where('id', $id)
                ->update([
                    'qty' => $request->quantity, 
                    'shipping_cost' => round($shippingCost),
                    'total_without_shipping' => $cart->product_price*$request->quantity,
                    'total_with_shipping' => ($cart->product_price*$request->quantity) + ($cart->shipping_cost * $request->quantity),
                ]);
            
            $cart = Cart::all();    
        } else{
            // Panier local
            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                if ($request->quantity > 0) {
                    $cart[$id]['qty'] = $request->quantity;

                    $cart[$id]['total_without_shipping'] = $cart[$id]['product_price'] * $request->quantity;
                    $cart[$id]['total_with_shipping'] = ($cart[$id]['product_price'] * $request->quantity)+ ($request->quantity * $cart[$id]['shipping_cost']);

                    // Récupérer le prix de la livraison du produit 
                    $product = Product::find($id);

                    $cart[$id]['shipping_cost'] = ($product->shipping_cost * $request->quantity);                
                } else {
                    unset($cart[$id]);
                }
            }
            
            session()->put('cart', $cart);

            Session::put('bouton-ajoute-au-panier', true);
            
            $cartData = session()->get('cart', []);
            $cart = $cartData;
        }      
        
        $totalCartWithoutShipping = 0;
        $totalShipping = 0;
        $totalCartWithShipping = 0;

        foreach ($cart as $cartItem) {
            $totalCartWithoutShipping += $cartItem['total_with_shipping'];
            $totalShipping += $cartItem['shipping_cost'];
        }

        $totalCartWithShipping = $totalCartWithoutShipping + $totalShipping;

        // Mettre à jour les valeurs affichées dans la section "Total du panier"
        return response()->json([
            'success' => true,
            'totalCartWithoutShipping' => $totalCartWithoutShipping,
            'totalShipping' => $totalShipping,
            'totalCartWithShipping' => $totalCartWithShipping,
            'cart' => $cart,
        ]);
    }     

    public function removeProduct($id)
    {
        if (Session::has('client')) {
            $deleted = Cart::where('id', $id)->delete();

            $cart = Cart::all();

            $cart->each(function ($item) {
                $item->product_image = asset('storage/' . $item->product_image);
            });

            $html = '';
            $totalCartWithoutShipping = 0;
            $totalShipping = 0;
            $totalCartWithShipping = 0;           

            foreach ($cart as $cartInfos) {
                $modifyUrl = route('modify_qty', ['id' => $cartInfos->id]);

                $html .= '<tr class="text-center">';
                $html .= '<td class="product-remove">';
                $html .= '<a href="#" class="remove-product" data-id="' . $cartInfos->id . '">';
                $html .= '<span class="ion-ios-close"></span>';
                $html .= '</a>';
                $html .= '</td>';
                $html .= '<td class="image-prod"><div class="img" style="background-image:url(' . $cartInfos->product_image . ');"></div></td>';
                $html .= '<td class="product-name"><h3>' . $cartInfos->product_name . '</h3></td>';
                $html .= '<td class="price">' . $cartInfos->product_price . ' €</td>';
                $html .= '<td class="price">' . $cartInfos->shipping_cost . ' €</td>';
                $html .= '<td class="quantity">';
                $html .= '<div class="input-group mb-3">';
                $html .= '<form action="' . $modifyUrl . '" method="POST" id="modifierQtyForm">';
                $html .= csrf_field();
                $html .= '<input type="number" name="quantity" id="quantity" class="quantity form-control input-number" value="' . $cartInfos->qty . '" min="1" max="100" data-id="' . $cartInfos->id . '">';
                $html .= '</form>';
                $html .= '</div>';
                $html .= '</td>';
                $html .= '<td class="total">' . $cartInfos->total_with_shipping  . ' €</td>';
                $html .= '</tr>';
                   
                $totalCartWithoutShipping += $cartInfos->total_with_shipping ;
                $totalShipping += $cartInfos->shipping_cost;
            }

            $totalCartWithShipping = $totalCartWithoutShipping + $totalShipping;

            $nbItemsCart = Cart::count();

            return response()->json([
                'success' => true, 
                'html' => $html, 
                'nbItemsCart' => $nbItemsCart,
                'totalCartWithoutShipping' => $totalCartWithoutShipping,
                'totalShipping' => $totalShipping,
                'totalCartWithShipping' => $totalCartWithShipping
            ]);            
        } else {
            $productId = $id; // Utiliser l'ID du produit à supprimer

            $cart = session()->get('cart');

            // Supprimer le produit du panier en utilisant l'ID du produit
            if (isset($cart[$productId])) {
                unset($cart[$productId]);
                session()->put('cart', $cart);
            }

            $cartData = session()->get('cart', []);
            $cart = Cart::hydrate($cartData);

            // Nombre d'articles dans le panier local
            $nbItemsCart = count($cart);
            // Calculer le total du panier local
            $totalCartWithoutShipping = collect($cart)->sum('total_without_shipping');
            $totalCartWithShipping = collect($cart)->sum('total_with_shipping');
            $totalShipping = collect($cart)->sum('shipping_cost');

            // Mettre à jour les valeurs affichées dans la section "Total du panier"       
            return response()->json([
                'success' => true, 
                'nbItemsCart' => $nbItemsCart,
                'totalCartWithoutShipping' => $totalCartWithoutShipping,
                'totalShipping' => $totalShipping,
                'totalCartWithShipping' => $totalCartWithShipping,
            ]);
        }        
    }

    public function client_login(){
        return view('client.login');   
    }

    public function signup(){
        return view('client.signup');   
    }

    public function payment(){  
        // Si l'utilisateur n'est pas connecté, on l'invite à se connecter
        if(!Session::has('client')){
            return view('client.login');
        }  

        $products = Cart::all();

        if (request()->has('items')) {
            return view('client.cart')->with(compact('products'));
        } else {
            // Récuper les informations à afficher             
            $cart = Cart::all();
            
            // Total des achats (sans frais de livraison)
            $totalCartWithoutShipping = 0;

            // Total des frais de livraison 
            $totalShipping = 0;

            // Total du panier avec frais de livraison 
            $totalCartWithShipping = 0; 

            foreach ($cart as $cartInfos) {      
                $totalCartWithoutShipping += $cartInfos->total_with_shipping ;
                $totalShipping += $cartInfos->shipping_cost;
            }

            $totalCartWithShipping = $totalCartWithoutShipping + $totalShipping;

            return view('client.checkout', [
                'totalCartWithoutShipping' => $totalCartWithoutShipping,
                'totalShipping' => $totalShipping,
                'totalCartWithShipping' => $totalCartWithShipping
            ]);            
        } 
    }

    public function pay(Request $request)
    {
        $panier = Cart::all();
    
        if (count($panier) == 0) {
            return view('client.cart');
        }
    
        $total = 0;
    
        foreach ($panier as $article) {
            $total += $article->product_price;
        }
    
        Stripe::setApiKey('sk_test_51MmMexI1PfFa9viOiFBApIUDIvAPP36mJpYchDJoQ45QbP8fusojSYtejg2uCnFX8rR04ljCMo1RYCFcnZgRgRQw0001pussSD');
    
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $total * 100,
                "currency" => "eur",
                "source" => $request->input('stripeToken'),
                "description" => "Test de paiement"
            ));
    
            // Sauvegarder la commande
            $order = new Order();
            $order->nom = $request->input('fullname');
            $order->adresse = $request->input('address');
            $order->panier = json_encode($panier);
            $order->payment_id = $charge->id;
            $order->credit_card = $request->input('card-number');
    
            $order->save();
    
            // Récupérer les infos de commandes
            $orders = Order::where('payment_id', $charge->id)->get();
    
            $transformedOrders = $orders->transform(function ($order, $key) {
                $order->panier = json_decode($order->panier);
    
                // Calculer le total pour chaque commande
                $totalSansLivraison = 0;
                $totalLivraison = 0;
                $totalAvecLivraison = 0;
    
                foreach ($order->panier as $item) {
                    $totalSansLivraison += $item->total_without_shipping;
                    $totalLivraison += $item->shipping_cost;
                    $totalAvecLivraison += $item->total_with_shipping;
                }
    
                $order->totalSansLivraison = $totalSansLivraison;
                $order->totalLivraison = $totalLivraison;
                $order->totalAvecLivraison = $totalAvecLivraison;
    
                return $order;
            });

            $email = Session::get('client')->email;
    
            Mail::to($email)->send(new SendMail($transformedOrders));

            Session::forget('cart');
    
            return view('client.confirmOrder', ['orders' => $transformedOrders]);
        } catch (\Exception $e) {
            Session::put('error');
            return redirect::to('/payment')->with('error', $e->getMessage());
        }
    }   

    public function getOrdersDetails(Request $request)
    {
        $orders = Order::where('id', $request->orderId)->get();
    
          $transformedOrders = $orders->transform(function ($order, $key) {
              $order->panier = json_decode($order->panier);
  
              // Calculer le total pour chaque commande
              $totalSansLivraison = 0;
              $totalLivraison = 0;
              $totalAvecLivraison = 0;
  
              foreach ($order->panier as $item) {
                  $totalSansLivraison += $item->total_without_shipping;
                  $totalLivraison += $item->shipping_cost;
                  $totalAvecLivraison += $item->total_with_shipping;
              }
  
              $order->totalSansLivraison = $totalSansLivraison;
              $order->totalLivraison = $totalLivraison;
              $order->totalAvecLivraison = $totalAvecLivraison;
  
              return $order;
        });
        
        return response()->json(['success' => true, 'order' => $transformedOrders]);
    }

    public function creer_compte(Request $request){
        $this->validate($request, [
            'email' => 'email|required',
            'password' => 'required|min:4'
        ]);

        $client = new Client();
        $client->name = $request->input('name');
        $client->email = $request->input('email');
        $client->password = bcrypt($request->input('password'));

        $client->save();

        return back()->with('status', 'Votre compte a été créé !');
    }

    public function acceder_compte(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|required',
            'password' => 'required|min:4'
        ]);
    
        $client = Client::where('email', $request->input('email'))->first();
        $cart = Cart::all();
    
        if ($client) {
            if (Hash::check($request->input('password'), $client->password)) {
                Session::put('client', $client);

                // Enregistrement du panier local en DB

                // Récupérer l'id de l'utlisateur (client)
                $clientId = $client->id;

                // Récupérer le panier local
                $cart = session()->get('cart');

                // Vérifier si le panier local n'est pas vide
                if ($cart) {
                    foreach ($cart as $productId => $item) {
                        // Vérifier si l'article existe déjà dans le panier de l'utilisateur
                        $cartItem = Cart::where('user_id', $clientId)
                            ->where('product_id', $item['product_id'])
                            ->first();

                        if ($cartItem) {
                            // L'article existe déjà, mettre à jour la quantité
                            $cartItem->qty += $item['qty'];
                            $cartItem->save();
                        } else {
                            // Ajouter l'article au panier de l'utilisateur
                            Cart::create([
                                'user_id' => $clientId,
                                'product_id' => $item['product_id'],
                                'product_name' => $item['product_name'],
                                'product_price' => $item['product_price'],
                                'product_image' => $item['product_image'],
                                'shipping_cost' => $item['shipping_cost'],
                                'qty' => $item['qty'],
                                'total_without_shipping' => $item['total_without_shipping'],
                                'total_with_shipping' => $item['total_with_shipping'],
                            ]);
                        }
                    }

                    // Supprimer le panier local de la session
                    session()->forget('cart');
                }
    
                $previousUrl = url()->previous();

                if ($previousUrl == url('/payment')) {
                    return redirect('/payment');
                } else {
                    if (Session::has('wishlist_product_id')) {
                        $productId = Session::get('wishlist_product_id');
                        Session::forget('wishlist_product_id'); 
                        return redirect('article_by_reference/'.$productId);
                    } else {
                        return redirect('/');
                    }  
                }
            } else {
                return back()->with("status", "Mauvais mot de passe");
            }
        } else {
            return back()->with("status", "Vous n'avez pas de compte");
        }
    }    

    public function account()
    {
        return view('client.account'); 
    }

    // Afficher les informations du client
    public function getInfosClient()
    {
        $clientId = Session::get('client.id');
		
        $clientInfos = Client::find($clientId);

        return response()->json([
            'success' => true,
            'data' => $clientInfos,
        ]);        
    }

	public function updateInfosClient(Request $request)
	{
		// Récupérer les données du formulaire soumis et valider les champs
		$data = $request->validate([
			'name' => 'required|string|max:255',
			'email' => 'required|email',
			'job' => 'nullable|string|max:255',
		]);

		// Récupérer le clientId depuis la session
		$clientId = Session::get('client.id');

		// Rechercher le client en utilisant le clientId (vous pouvez sauter cette étape si vous utilisez directement l'utilisateur connecté avec auth()->user())
		$client = Client::find($clientId);

		// Vérifier si le client existe
		if (!$client) {
			return response()->json(['success' => false, 'message' => 'Client non trouvé !'], 404);
		}

		// Mettre à jour les informations du client avec les données du formulaire soumis
		$client->name = $data['name'];
		$client->email = $data['email'];
		$client->job = $data['job'];
		$client->save();

		// Rediriger l'utilisateur vers la page "account" après la mise à jour réussie       
		return response()->json(['success' => true, 'message' => 'Vos informations ont été mises à jour avec succès !']);
	}

    public function getOrders()
    {
        $name = Session::get('client.name');

        $orders = Order::where('nom', $name)->get(); 

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

    // Annuler ou activer une commande
    public function cancelOrder(Request $request)
    {
        // Récupérer l'id de la commande
        $orderId = $request->input('orderId');
        $order = Order::find($orderId);

        if($order->canceled == 0){
            $order->canceled = 1;
            $message = 'La commande a été annulée';
        } else{
            $order->canceled = 0;
            $message = 'La commande a été activée';
        }

        $order->save();

        return response()->json(['success' => true, 'message' => $message, 'orderId' => $orderId]);
    }

    public function logout(){
        Session::forget('client');   
        $nbItemsCart = count(session()->get('cart', []));          
        return view('client.home')->with(compact('nbItemsCart'));        
    }

    public function shipping_informations()
    {             
        return view('client.shipping');
    }

    public function returns_informations()
    {
        return view('client.returns');
    }

    public function conditions_informations()
    {
       return view('client.conditions');
    }
	
	public function general_conditions_informations()
    {
       return view('client.generalConditions');
    }

    public function privacy_informations()
    {                  
        return view('client.privacy');
    }
	
	 public function legal_notice_informations()
    {                  
        return view('client.legal');
    }
}
