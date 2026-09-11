<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;



class ProductController extends Controller
{
    // Add your methods for handling product-related actions here
    // For example, you might have methods like index, create, store, edit, update, destroy, etc.
    
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('admin.login')->withErrors(['error' => 'You must be logged in to view this page.']);
        }
        $products = Product::all(); // Fetch all products
        return view('product.index',compact('products')); // Assuming you have a view for listing products
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('admin.login')->withErrors(['error' => 'You must be logged in to add a product.']);
        }
        $categories = Category::all(); 
        return view('product.addProduct',compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image.*' => 'image|mimes:jpg,jpeg,png,webp'
            // Add validation for image if needed
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;
        $imagePath= $request->file('image')->store('products', 'public');
        $product->image = $imagePath;
        $product->save();
        return redirect()->route('products.index');
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('admin.login')->withErrors(['error' => 'You must be logged in to add a product.']);
        }
        $products=Product::findorfail($id);
        $categories = Category::all();
        return view('product.productupdate', compact('products', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image.*' => 'image|mimes:jpg,jpeg,png,webp'
        ]);
        
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            if($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);

            }
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();
        return redirect()->route('products.index');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('admin.login')->withErrors(['error' => 'You must be logged in to add a product.']);
        }
        $product = Product::findOrFail($id);
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('products.index');
    }
    public function show($id){
        
        $product=Product::findOrFail($id);
        $sameCategoryProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->take(6)
            ->get();
        $products = $sameCategoryProducts;

        if ($products->count() < 6) {
            $fallbackProducts = Product::where('id', '!=', $id)
                ->whereNotIn('id', $products->pluck('id'))
                ->inRandomOrder()
                ->take(6 - $products->count())
                ->get();

            $products = $products->concat($fallbackProducts);
        }

        $isFavorite = false;

        if (Auth::check()) {
            $user = Auth::user();
            if (method_exists($user, 'wishlists')) {
                $isFavorite = $user->wishlists()->where('product_id', $product->id)->exists();
            }
        }

        return view('product.show', compact('product', 'products', 'isFavorite'));
    }
}
