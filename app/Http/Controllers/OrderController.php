<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    // Récupérer la dernière commande
    public function getLastOrder()
    {
        $userName = Session::get('client.name');
    
        $lastOrder = Order::where('nom', $userName)->latest()->first(); 
        return $lastOrder;
    }  
    
    public function getAllOrders()
    {
        $userName = Session::get('client.name');
    
        $orders = Order::where('nom', $userName)->get(); 

        return view('client.allOrders')->with('orders', $orders);
    }
}


