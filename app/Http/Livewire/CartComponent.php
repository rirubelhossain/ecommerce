<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Cart;

class CartComponent extends Component
{   
    //Cart Quantity Increase
    public function increaseQuantity($rowId)
    {
        $product = Cart::get($rowId) ;
        $qty = $product->qty + 1 ;
        Cart::update($rowId , $qty );
    }

    //Cart Quantity Decrease
    public function decreaseQuantity($rowId)
    {
        $product = Cart::get($rowId) ;
        $qty = $product->qty - 1 ;
        Cart::update($rowId , $qty );
    }

    //Delete Cart Iteam
    public function destroy($rowId)
    {
        Cart::remove($rowId) ;
        session()->flash('success_message','Iteam has been removed') ;
    }

    ///Delete all cart
    public function destroyAll()
    {
        Cart::destroy();
    }

    public function render()
    {
        return view('livewire.cart-component')->layout('layouts.base');
    }
}
