<?php

namespace App\Http\Livewire;

use App\Models\Product ;
use Livewire\Component;
use Livewire\WithPagination ; 
///use App\Http\Livewire\Product ;
use Cart ;
class ShopComponent extends Component
{   
    public function store($probuct_id , $product_name , $product_price)
    {
        Cart::add($probuct_id , $product_name , 1 , $product_price )->associate('App\Models\Product');
        session()->flash('success_message' , 'Item added in Cart') ;
        return redirect()->route('product.cart') ;
    }

    use WithPagination ;  
    public function render()
    {   
        $products = Product::paginate(12);
        ///$products = Product::paginate(12);
        return view('livewire.shop-component',['products'=>$products])->layout('layouts.base');

    }
}
