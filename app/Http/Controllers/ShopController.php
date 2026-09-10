<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Request $request){
        $query = Product::with('category');
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
        $sort = $request->input('sort', 'latest');
        match ($sort) {
            'price_low' => $query->orderBy('price'),
            'price_high' => $query->orderByDesc('price'),
            default => $query->latest(),
        };

        $products = $query->paginate(6)->withQueryString();
        $categories = Category::withCount('products')->orderBy('name')->get();
        $allProductsCount = Product::count();
        $wishlistProductIds = Auth::check()
            ? Auth::user()->wishlists()->pluck('products.id')->all()
            : [];

        return view('shop.index', compact('categories', 'products', 'allProductsCount', 'sort', 'wishlistProductIds'));
    }
}
