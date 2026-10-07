<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\KerjaPraktik;
use App\Models\TugasAkhir;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function($view){
            $unreadCount = 0;

            if (Auth::check() && Auth::user()->role == 'user'){
                $unreadCount = Notification::where('user_id', Auth::id())->where('is_read', false)->count();
            }

            $view->with('unreadNotifications', $unreadCount);
        });

        view::composer('admin.partials.sidebar', function($view){
            $pendingKpCount = 0;
            $pendingTaCount = 0;

            if(Auth::check() && Auth::user()->role == 'admin'){
                $pendingKpCount = KerjaPraktik::whereIn('status', ['terkumpul', 'revisi'])->count();
                $pendingTaCount = TugasAkhir::whereIn('status', ['terkumpul', 'revisi'])->count();
            }

            $view->with('pendingKpCount', $pendingKpCount);
            $view->with('pendingTaCount', $pendingTaCount);
        });
    }
}
