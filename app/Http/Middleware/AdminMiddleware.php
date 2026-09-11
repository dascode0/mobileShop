<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     * Only allow logged in users with the is_admin flag through to admin pages.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('admin.login')->withErrors([
                'error' => 'You must be logged in as an admin to view this page.',
            ]);
        }

        if (!$user->is_admin) {
            // A regular customer tried to reach an admin page — send them back
            // to their own account rather than destroying their session.
            return redirect()->route('home')->withErrors([
                'error' => 'You do not have permission to view this page.',
            ]);
        }

        return $next($request);
    }
}
