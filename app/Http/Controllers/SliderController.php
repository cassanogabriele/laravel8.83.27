<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Slider;

class SliderController extends Controller
{
    public function ajouterslider(){
        return view('admin.ajouterSlider');
    }

    public function sauverslider(Request $request){
        $this->validate($request, [
            'description1' => 'required',
            'description2' => 'required',
            'slider_image' => 'required'
        ]);   

        $slider = new Slider();
        $slider->description1 = $request->input('description1');
        $slider->description2 = $request->input('description2');
        $slider->status = 1;
      
        // Enregistrement de l'image
        if ($request->hasFile('slider_image')) {
            $file = $request->file('slider_image');
            $path = Storage::disk('public')->putFile('slider_images', $file);
            $slider->slider_image = $path;
        } else{
            $file = "no-image.jpg";
        }   
        
        $slider->save();
    
        return redirect('/ajouterslider')->with('status', 'Le slider a été ajoutée');
    }       

    public function sliders(){
        $sliders = Slider::get();
        return view('admin.sliders')->with('sliders', $sliders);
    }

    public function edit_slider($id){
        $sliders = Slider::find($id);

        return view('admin.editslider')->with('slider', $sliders);
    }

    public function modifierslider(Request $request){
        $this->validate($request, [
            'description1' => 'required',
            'description2' => 'required',
            'slider_image' => 'image|nullable|max:1999',
        ]);   

        $slider = Slider::find($request->input('id'));      
        $slider->description1 = $request->input('description1');
        $slider->description2 = $request->input('description2');
        $slider->status = 1;   
        
        // Enregistrement de l'image  
        if ($request->hasFile('slider_image')) {
            $file = $request->file('slider_image');
            $path = Storage::disk('public')->putFile('slider_images', $file);

            // Suppression de l'ancienne image    
            if($slider->slider_image != "no-image.jpg"){          
                Storage::delete('public/'.$slider->slider_image);           
            }
            
            $slider->slider_image = $path;
        } else{
            $file = "no-image.jpg";
        }
        

        $slider->update();
    
        return redirect('/sliders')->with('status', 'Le slider a été modifié');
    }

  
    public function delete_slider($id){
        $slider = Slider::find($id);
       
           
        if($slider->slider_image != "no-image.jpg"){          
            Storage::delete('public/'.$slider->slider_image);           
        }

        $slider->delete();

        return redirect('/sliders')->with('status', 'Le produit ' . $slider->product_name . ' a été supprimé');
    }

    public function activate_slider($id){
        $slider = Slider::find($id);

        $slider->status = 1;

        $slider->update();

        return redirect('/sliders')->with('status', 'Le produit a été activé');
    }

    public function deactivate_slider($id){
        $slider = Slider::find($id);

        $slider->status = 0;

        $slider->update();

        return redirect('/sliders')->with('status', 'Le produit a été désactivé');
    }
}
