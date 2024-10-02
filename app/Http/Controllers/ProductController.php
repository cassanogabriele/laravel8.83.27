<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function ajouterproduit(){
        $categories = Category::all()->pluck('category_name', 'id');
    
        return view('admin.ajouterProduit')->with('categories', $categories);
    }

    public function sauverproduit(Request $request){
        $this->validate($request, [
            'product_name' => 'required|unique:products',
            'product_price' => 'required',
            'product_category' => 'required',
            'product_image' => 'image|nullable|max:1999',
        ]);        
            
        $product = new Product();
        $product->product_name = $request->input('product_name');
        $product->product_price = $request->input('product_price');
        $product->product_category = $request->input('product_category');
        $product->status = 1;
        
        // Enregistrement de l'image
        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $path = Storage::disk('public')->putFile('product_images', $file);
            $product->product_image = $path;
        } else{
            $file = "no-image.jpg";
        }
        
        $product->save();
    
        return redirect('/produit')->with('status', 'Le produit ' . $product->product_name . ' a été insérée');
    }
       
    public function produits(){
        $products = Product::get();

        return view('admin.produits')->with('products', $products);
    }

    public function edit_product($id){
        $product = Product::find($id);
        $categories = Category::all()->pluck('category_name', 'id');

        return view('admin.editproduit')->with('product', $product)->with('categories', $categories);
    }

    public function modifierproduit(Request $request){
        $this->validate($request, [
            'product_name' => 'required',
            'product_price' => 'required',
            'product_category' => 'required',
            'product_image' => 'image|nullable|max:1999',
        ]);        
        
        $product = Product::find($request->input('id'));

        $product->product_name = $request->input('product_name');
        $product->product_price = $request->input('product_price');
        $product->product_category = $request->input('product_category');
        
        // Enregistrement de l'image  
        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $path = Storage::disk('public')->putFile('product_images', $file);
            
            // Suppression de l'ancienne image    
            if($product->product_image != "no-image.jpg"){
                Storage::delete('public/'.$product->product_image);           
            }
            
            $product->product_image = $path;
        } else{
            $file = "no-image.jpg";
        }       
        
        $product->update();
        
        return redirect('/produits')->with('status', 'Le produit ' . $product->product_name . ' a été mise à jour');
        
    }

    public function delete_product($id){
        $product = Product::find($id);
       
        // Enregistrement de l'image       
        if($product->product_image != "no-image.jpg"){          
            Storage::delete('public/'.$product->product_image);           
        }

        $product->delete();

        return redirect('/produits')->with('status', 'Le produit ' . $product->product_name . ' a été supprimé');
    }

    public function activate_product($id){
        $product = Product::find($id);

        $product->status = 1;

        $product->update();

        return redirect('/produits')->with('status', 'Le produit ' . $product->product_name . ' a été activé');
    }

    public function deactivate_product($id){
        $product = Product::find($id);

        $product->status = 0;

        $product->update();

        return redirect('/produits')->with('status', 'Le produit ' . $product->product_name . ' a été désactivé');
    }
}
