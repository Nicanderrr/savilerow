<?php

namespace App\Http\Middleware;

use App\Models\TrafficLog;
use App\Services\Analytics\GeoResolver;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class TrackTraffic
{
    public function handle(Request $request, Closure $next): Response
    {
        $request->attributes->set('traffic_started_at', microtime(true));

        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        if (! Schema::hasTable('traffic_logs') || $this->shouldSkip($request)) {
            return;
        }

        $geo = app(GeoResolver::class)->fromRequest($request);
        $startedAt = (float) $request->attributes->get('traffic_started_at', microtime(true));

        TrafficLog::create(array_merge($geo, [
            'session_id' => $request->hasSession() ? $request->session()->getId() : null,
            'ip_hash' => $geo['ip_address'] ? hash('sha256', $geo['ip_address'].config('app.key')) : null,
            'method' => $request->method(),
            'path' => '/'.ltrim($request->path(), '/'),
            'route_name' => $request->route()?->getName(),
            'status_code' => $response->getStatusCode(),
            'referer' => str($request->headers->get('referer'))->limit(255)->toString(),
            'user_agent' => str($request->userAgent())->limit(600)->toString(),
            'device_type' => app(GeoResolver::class)->deviceType($request->userAgent()),
            'duration_ms' => (int) round((microtime(true) - $startedAt) * 1000),
            'visited_at' => now(),
        ]));
    }

    private function shouldSkip(Request $request): bool
    {
        return $request->is('build/*')
            || $request->is('storage/*')
            || $request->is('favicon.ico')
            || $request->is('up')
            || $request->is('_ignition/*');
    }
}
