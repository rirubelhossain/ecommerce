<?php

namespace App\Http\Livewire;

use App\Models\Product ;
use Livewire\Component;
use Livewire\WithPagination ; 
///use App\Http\Livewire\Product ;
use Cart ;
use App\Models\Category ;
class SearchComponent extends Component
{   
    public $sorting ;
    public $pagesize ;

    /// Search property
    public $search;
    public $product_cat ;
    public $product_cat_id ;

    public function mount()
    {
        $this->sorting = "default";
        $this->pagesize = 12;
        $this->fill(request()->only('search','product_cat' , 'product_cat_id'));
    }

    ///store function
    public function store($probuct_id , $product_name , $product_price)
    {
        Cart::add($probuct_id , $product_name , 1 , $product_price )->associate('App\Models\Product');
        session()->flash('success_message' , 'Item added in Cart') ;
        return redirect()->route('product.cart') ;
    }

    //pagination
    use WithPagination ;  
    public function render()
    {   
        ///price sorting and asc or desc order condition here 
        if($this->sorting == "date")
        {
            $products = Product::where('name' ,'like','%'.$this->search . '%')->where('category_id','like','%'.$this->product_cat_id.'%')->orderBy('created_at', 'DESC')->paginate($this->pagesize);
        }
        else if($this->sorting == "price")
        {
            $products = Product::where('name' ,'like','%'.$this->search . '%')->where('category_id', 'like','%'.$this->product_cat_id.'%')->orderBy('regular_price', 'ASC')->paginate($this->pagesize);
        }
        else if($this->sorting == "price-desc")
        {
            $products = Product::where('name' ,'like','%'.$this->search . '%')->where('category_id', 'like','%'.$this->product_cat_id.'%')->orderBy('regular_price', 'DESC')->paginate($this->pagesize);
        }
        else{
            $products = Product::where('name' ,'like','%'.$this->search . '%')->where('category_id', 'like','%'.$this->product_cat_id.'%')->paginate($this->pagesize);
        }
        ///All categories
        $categories = Category::all() ;
        

        ///$products = Product::paginate(12);
        return view('livewire.search-component',['products'=>$products,'categories'=>$categories])->layout('layouts.base');

    }
}
