<?php
 
namespace App\Http\Middleware;
 
// ============================================================
// works-web  →  app/Http/Middleware/RequireWebSession.php
//
// Protects any route that needs a logged-in web user.
// Register it in bootstrap/app.php (Laravel 11) or
// app/Http/Kernel.php (Laravel 10) then use it on routes.
// ============================================================
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
 
class RequireWebSession
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('web_user')) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
 
            // Store intended URL so we can redirect back after login
            session()->put('url.intended', $request->fullUrl());
 
            return redirect()->route('jobs.index')
                ->with('info', 'Please sign in to access that page.');
        }
 
        return $next($request);
    }
}
