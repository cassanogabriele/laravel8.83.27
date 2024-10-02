<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function ajouterCategorie(){
        return view('admin.ajouterCategorie');
    }

    public function sauvercategorie(Request $request){
        $this->validate($request, ['category_name' => 'required|unique:categories']);
       
        $category = new Category();
        
        $category->category_name = $request->input('category_name');
     
        $category->save();

        return redirect('/ajoutercategorie')->with('status', 'La catégorie ' .$category->category_name  .' a été créée');
    }

    public function categories(){     
        return view('admin.categories');
    }

    public function edit_category($id){
        $categorie = Category::find($id);
        return view('admin.editcategory')->with('categorie', $categorie);   
    }

    public function modifiercategorie(Request $request){
        $this->validate($request, ['category_name' => 'required' ]);

        $categorie = Category::find($request->input('id'));
        
        $categorie->category_name = $request->input('category_name');
        $categorie->update();

        return redirect('/categories')->with('status', 'La catégorie' . $categorie->category_name  .' a été modifiée');        
    }

    public function delete_category($id){
        $categorie = Category::find($id);
        $categorie->delete();

        return redirect('/categories')->with('status', 'La catégorie' . $categorie->category_name  .' a été supprimée');    
    }
}
