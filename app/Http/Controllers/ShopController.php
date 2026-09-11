<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function searchProducts(Request $request)
    {
        $term = trim((string) $request->query('q', ''));
        if ($term === '') {
            return response()->json(['products' => []]);
        }

        $tokens = preg_split('/\s+/', mb_strtolower($term), -1, PREG_SPLIT_NO_EMPTY);
        $categories = Category::query()
            ->where(function ($query) use ($tokens) {
                foreach ($tokens as $token) {
                    $query->orWhere('name', 'like', '%' . $token . '%');
                }
            })
            ->limit(20)
            ->get(['id', 'name']);

        $products = Product::query()
            ->with('category:id,name')
            ->where(function ($query) use ($tokens) {
                foreach ($tokens as $token) {
                    $query->orWhere('name', 'like', '%' . $token . '%')
                        ->orWhere('description', 'like', '%' . $token . '%')
                        ->orWhereHas('category', function ($categoryQuery) use ($token) {
                            $categoryQuery->where('name', 'like', '%' . $token . '%');
                        });
                    if (is_numeric($token)) {
                        $query->orWhere('price', $token);
                    }
                }
            })
            ->limit(40)
            ->get(['id', 'name', 'description', 'price', 'image']);

        $productResults = $products->map(function (Product $product) use ($term, $tokens) {
            $name = mb_strtolower($product->name);
            $description = mb_strtolower((string) $product->description);
            $category = mb_strtolower((string) ($product->category->name ?? ''));
            $normalizedTerm = mb_strtolower($term);
            $score = $name === $normalizedTerm ? 1000 : 0;
            $score += str_starts_with($name, $normalizedTerm) ? 500 : 0;
            $score += str_contains($name, $normalizedTerm) ? 250 : 0;
            foreach ($tokens as $token) {
                $score += str_contains($name, $token) ? 100 : 0;
                $score += str_contains($category, $token) ? 70 : 0;
                $score += str_contains($description, $token) ? 25 : 0;
                if (is_numeric($token) && (float) $product->price === (float) $token) {
                    $score += 150;
                }
            }

            return [
                'type' => 'product',
                'id' => $product->id,
                'name' => $product->name,
                'price' => number_format($product->price, 2),
                'image' => $product->image ? asset('storage/' . $product->image) : null,
                'score' => $score,
            ];
        });

        $categoryResults = $categories->map(function (Category $category) use ($term, $tokens) {
            $name = mb_strtolower($category->name);
            $normalizedTerm = mb_strtolower($term);
            $score = $name === $normalizedTerm ? 900 : 0;
            $score += str_starts_with($name, $normalizedTerm) ? 450 : 0;
            $score += str_contains($name, $normalizedTerm) ? 220 : 0;
            foreach ($tokens as $token) {
                $score += str_contains($name, $token) ? 80 : 0;
            }

            return [
                'type' => 'category',
                'id' => $category->id,
                'name' => $category->name,
                'price' => null,
                'image' => null,
                'score' => $score,
            ];
        });

        $results = $productResults
            ->concat($categoryResults)
            ->sortByDesc('score')
            ->take(10)
            ->values();

        return response()->json(['products' => $results]);
    }

    public function index(Request $request){
        $query = Product::with('category');
        $search = trim((string) $request->query('search', ''));
        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($categoryQuery) use ($search) {
                        $categoryQuery->where('name', 'like', '%' . $search . '%');
                    });
                if (is_numeric($search)) {
                    $query->orWhere('price', $search);
                }
            });
        }
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

        return view('shop.index', compact('categories', 'products', 'allProductsCount', 'sort', 'wishlistProductIds', 'search'));
    }
}
