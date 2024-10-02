<?php
namespace App;
use Illuminate\Support\Facades\DB;


class CartUser{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;

    public function add($item, $product_id){
        $storedItem = [
            'qty' => 0, 
            'product_id' => 0, 
            'product_name' => $item->product_name,
            'product_price' => $item->product_price, 
            'product_image' => $item->product_image, 
            'item' =>$item];       

        if($this->items){
            if(array_key_exists($product_id, $this->items)){
                $storedItem = $this->items[$product_id];
            }
        }

        $storedItem['qty']++;     
        $storedItem['product_id'] = $product_id;
        $storedItem['product_name'] = $item->product_name;
        $storedItem['product_price'] = $item->product_price;
        $storedItem['product_image'] = $item->product_image;          

        $this->totalQty++;
        $this->totalPrice += $item->product_price;
        $this->items[$product_id] = $storedItem;   
       
        DB::table('cart')->updateOrInsert(
            ['product_id' => $product_id],
            [
                'product_name' => $item->product_name,
                'product_price' => $item->product_price,
                'product_image' => $item->product_image,
                'qty' => $storedItem['qty'],
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    public function updateQty($id, $qty, $price){   
        DB::table('cart')
            ->where('product_id', (int)$id)
            ->update(['qty' => $qty, 'product_price' => $qty*$price]);            
    }

    public function removeItem($id){
        $this->totalQty -= $this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['product_price'] * $this->items[$id]['qty'];
        unset($this->items[$id]);
    }
}
?>