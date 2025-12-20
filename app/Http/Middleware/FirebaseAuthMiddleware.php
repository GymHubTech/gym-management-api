<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\Auth\FirebaseService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FirebaseAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        try {
            $verifiedToken = FirebaseService::auth()->verifyIdToken($token);
            $firebaseUid = $verifiedToken->claims()->get('sub');

            // Fetch or create local user
            $user = User::where('firebase_uid', $firebaseUid)->first();

            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $request->attributes->set('user', $user);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        return $next($request);
    }
}
