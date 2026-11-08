<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Support\CurrentUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class ShareLayoutData
{
    public function handle(Request $request, Closure $next): Response
    {
        View::share('currentUser', CurrentUser::get());
        View::share('switchableUsers', User::orderBy('name')->get());
        View::share('cartCount', array_sum(session('cart', [])));

        return $next($request);
    }
}
