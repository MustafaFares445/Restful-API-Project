<?php

namespace App\Providers;

use App\Mail\UserCreated;
use App\Mail\UserMailChange;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

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
        User::created(function ($user) {
            Mail::to($user)->send(new UserCreated($user));
        });

        User::updated(function ($user) {
            if ($user->isDirty('email')) {
                Mail::to($user)->send(new UserMailChange($user));

            }
        });

        Product::updated(function (Product $product) {
             if ($product->quantity == 0 && $product->isAvailable()) {
                 $product->status = $product::UNAVAILABLE_PRODUCT;

                 $product->save();
             }
         });
    }
}
