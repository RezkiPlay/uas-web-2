<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user && $user->role === 'pelamar') {
            if (!$user->applicant) {
                return redirect()->route('applicant.profile.edit')->withError('Silakan lengkapi profil Anda terlebih dahulu sebelum melamar pekerjaan.');
            }
        }

        return $next($request);
    }
}
