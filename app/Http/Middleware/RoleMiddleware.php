<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if ($request->user() && $request->user()->role === $role) {
            return $next($request);
        }

        // Redirect atau tampilkan pesan error jika user tidak memiliki role yang sesuai
        return redirect('/dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki izin Admin.');
    }
}
