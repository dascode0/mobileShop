<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Wishlist;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        View::composer('layout.user', function ($view) {
            $cartCount = 0;
            $wishlistCount = 0;

            if (Auth::check()) {
                $cartCount = (int) Cart::where('user_id', Auth::id())
                    ->distinct()
                    ->count('product_id');
                $wishlistCount = Wishlist::where('user_id', Auth::id())->count();
            }

            $view->with([
                'navigationCategories' => Category::orderBy('name')->get(),
                'cartCount' => $cartCount,
                'wishlistCount' => $wishlistCount,
            ]);
        });
    }
}
