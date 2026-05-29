<?php

namespace App\Services\Analytics;

use Illuminate\Http\Request;

class GeoResolver
{
    private const COUNTRIES = [
        'AE' => 'United Arab Emirates',
        'AU' => 'Australia',
        'CA' => 'Canada',
        'DE' => 'Germany',
        'FR' => 'France',
        'GB' => 'United Kingdom',
        'GH' => 'Ghana',
        'NG' => 'Nigeria',
        'US' => 'United States',
        'ZA' => 'South Africa',
    ];

    public function fromRequest(Request $request): array
    {
        $countryCode = strtoupper((string) (
            $request->headers->get('CF-IPCountry')
            ?: $request->headers->get('X-Vercel-IP-Country')
            ?: $request->headers->get('CloudFront-Viewer-Country')
            ?: $request->headers->get('X-Country-Code')
            ?: ''
        ));

        if ($countryCode === 'XX' || strlen($countryCode) !== 2) {
            $countryCode = null;
        }

        return [
            'ip_address' => $request->ip(),
            'country_code' => $countryCode,
            'country' => $request->headers->get('X-Country')
                ?: ($countryCode ? (self::COUNTRIES[$countryCode] ?? $countryCode) : null),
            'region' => $request->headers->get('X-Region') ?: $request->headers->get('X-Vercel-IP-Country-Region'),
            'city' => $request->headers->get('X-City') ?: $request->headers->get('X-Vercel-IP-City'),
            'latitude' => is_numeric($request->headers->get('X-Latitude')) ? $request->headers->get('X-Latitude') : null,
            'longitude' => is_numeric($request->headers->get('X-Longitude')) ? $request->headers->get('X-Longitude') : null,
        ];
    }

    public function deviceType(?string $userAgent): string
    {
        $agent = strtolower($userAgent ?? '');

        return match (true) {
            str_contains($agent, 'tablet') || str_contains($agent, 'ipad') => 'tablet',
            str_contains($agent, 'mobile') || str_contains($agent, 'iphone') || str_contains($agent, 'android') => 'mobile',
            default => 'desktop',
        };
    }
}
