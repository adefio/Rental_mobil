<?php

namespace App\Http\Middleware;

use App\Auth\SupabaseGuard;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EdgeCachePublic
{
    private const CACHEABLE = [
        'landing' => 60,
        'katalog' => 60,
        'tentang' => 300,
        'kebijakan.privasi' => 300,
        'syarat.ketentuan' => 300,
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $ttl = self::CACHEABLE[$request->route()?->getName()] ?? null;

        $authenticated = $request->session()->has(SupabaseGuard::ACCESS_TOKEN_KEY);

        if ($ttl !== null && $request->isMethod('GET') && $response->getStatusCode() === 200 && ! $authenticated) {
            foreach ($response->headers->getCookies() as $cookie) {
                $response->headers->removeCookie($cookie->getName(), $cookie->getPath(), $cookie->getDomain());
            }

            $response->headers->set('Cache-Control', 'public, s-maxage='.$ttl.', stale-while-revalidate=60');
        }

        return $response;
    }
}
