<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    public function index(Request $request){
        $query=Product::query();
        if($request->category){
            $query->where('category_id',$request->category);
        }
        if($request->price){
            if($request->price == 'under-1000'){
                $query->where('price','<',1000);
            }elseif($request->price == '1000-5000'){
                $query->whereBetween('price',[1000,5000]);
            }elseif($request->price == 'above-5000'){
                $query->where('price','>',5000);}
        }
        $products=$query->paginate(9);
        $categories=Category::all();
        return view('shop.index',compact('categories','products'));
    }
}
