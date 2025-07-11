<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CoordinateExtractionService
{
    /**
     * Extract coordinates from various Google Maps URL formats
     */
    public function extractCoordinatesFromUrl(string $url): array
    {
        try {
            // Normalize URL
            $url = $this->normalizeUrl($url);

            // Validate URL format first
            if (!$this->isValidGoogleMapsUrl($url)) {
                throw new \Exception('فرمت لینک گوگل مپ صحیح نیست');
            }

            // Try direct extraction first (faster)
            $result = $this->extractFromDirectUrl($url);
            if ($result) {
                return $result;
            }

            // If direct extraction fails, follow redirects
            $finalUrl = $this->followRedirects($url);
            if ($finalUrl !== $url) {
                // Check if we got a consent page and extract from it
                if (str_contains($finalUrl, 'consent.google.com')) {
                    $result = $this->extractFromConsentUrl($finalUrl);
                    if ($result) {
                        return $result;
                    }
                }

                $result = $this->extractFromDirectUrl($finalUrl);
                if ($result) {
                    return $result;
                }
            }

            throw new \Exception('نتوانستیم مختصات را از لینک استخراج کنیم');

        } catch (\Exception $e) {
            Log::warning('Coordinate extraction failed', [
                'url' => $url,
                'error' => $e->getMessage()
            ]);

            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Extract coordinates from Google consent page URL
     */
    private function extractFromConsentUrl(string $consentUrl): ?array
    {
        try {
            // Parse the consent URL to get the continue parameter
            $parsedUrl = parse_url($consentUrl);
            if (!isset($parsedUrl['query'])) {
                return null;
            }

            parse_str($parsedUrl['query'], $queryParams);

            if (!isset($queryParams['continue'])) {
                return null;
            }

            // Decode the continue URL
            $continueUrl = urldecode($queryParams['continue']);

            Log::info('Extracting from consent continue URL', [
                'continue_url' => $continueUrl
            ]);

            // Try to extract coordinates from the continue URL
            return $this->extractFromDirectUrl($continueUrl);

        } catch (\Exception $e) {
            Log::warning('Failed to extract from consent URL', [
                'url' => $consentUrl,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Normalize URL for better processing
     */
    private function normalizeUrl(string $url): string
    {
        // Remove extra whitespace
        $url = trim($url);

        // Add protocol if missing
        if (!preg_match('/^https?:\/\//', $url)) {
            $url = 'https://' . $url;
        }

        return $url;
    }

    /**
     * Validate if URL is a Google Maps URL
     */
    private function isValidGoogleMapsUrl(string $url): bool
    {
        $validPatterns = [
            'maps.google.com',
            'maps.app.goo.gl',
            'goo.gl/maps',
            'goo.gl',
            'maps.google.co',
            'google.com/maps',
            'maps.googleapis.com',
            'earth.google.com',
            'consent.google.com' // Add consent page as valid
        ];

        $parsedUrl = parse_url($url);
        if (!$parsedUrl || !isset($parsedUrl['host'])) {
            return false;
        }

        $host = strtolower($parsedUrl['host']);

        foreach ($validPatterns as $pattern) {
            if (str_contains($host, $pattern)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Extract coordinates directly from URL without external services
     */
    private function extractFromDirectUrl(string $url): ?array
    {
        // Decode URL first
        $url = urldecode($url);

        // Pattern 1: @lat,lng,zoom format (most common)
        if (preg_match("/@(-?\d+\.?\d*),(-?\d+\.?\d*)(?:,\d+\.?\d*)?/", $url, $matches)) {
            return $this->formatCoordinates($matches[1], $matches[2]);
        }

        // Pattern 2: search/lat,lng format (from your consent URL)
        if (preg_match("/\/search\/(-?\d+\.?\d*),\s*([+\-]?\d+\.?\d*)/", $url, $matches)) {
            return $this->formatCoordinates($matches[1], $matches[2]);
        }

        // Pattern 3: ll=lat,lng format
        if (preg_match("/[?&]ll=(-?\d+\.?\d*),(-?\d+\.?\d*)/", $url, $matches)) {
            return $this->formatCoordinates($matches[1], $matches[2]);
        }

        // Pattern 4: q=lat,lng format
        if (preg_match("/[?&]q=(-?\d+\.?\d*),(-?\d+\.?\d*)/", $url, $matches)) {
            return $this->formatCoordinates($matches[1], $matches[2]);
        }

        // Pattern 5: center=lat,lng format
        if (preg_match("/[?&]center=(-?\d+\.?\d*),(-?\d+\.?\d*)/", $url, $matches)) {
            return $this->formatCoordinates($matches[1], $matches[2]);
        }

        // Pattern 6: daddr=lat,lng format (directions destination)
        if (preg_match("/[?&]daddr=(-?\d+\.?\d*),(-?\d+\.?\d*)/", $url, $matches)) {
            return $this->formatCoordinates($matches[1], $matches[2]);
        }

        // Pattern 7: saddr=lat,lng format (directions start)
        if (preg_match("/[?&]saddr=(-?\d+\.?\d*),(-?\d+\.?\d*)/", $url, $matches)) {
            return $this->formatCoordinates($matches[1], $matches[2]);
        }

        // Pattern 8: Place ID or direct coordinates in path
        if (preg_match("/\/(-?\d+\.?\d*),(-?\d+\.?\d*)/", $url, $matches)) {
            return $this->formatCoordinates($matches[1], $matches[2]);
        }

        // Pattern 9: 3d coordinates format
        if (preg_match("/!3d(-?\d+\.?\d*)!4d(-?\d+\.?\d*)/", $url, $matches)) {
            return $this->formatCoordinates($matches[1], $matches[2]);
        }

        // Pattern 10: Alternative 3d format
        if (preg_match("/!8m2!3d(-?\d+\.?\d*)!4d(-?\d+\.?\d*)/", $url, $matches)) {
            return $this->formatCoordinates($matches[1], $matches[2]);
        }

        // Pattern 11: Google Earth coordinates
        if (preg_match("/!2d(-?\d+\.?\d*)!3d(-?\d+\.?\d*)/", $url, $matches)) {
            return $this->formatCoordinates($matches[2], $matches[1]); // Note: lat/lng order
        }

        // Pattern 12: Embedded coordinates in data parameter
        if (preg_match("/data=.*!3d(-?\d+\.?\d*).*!4d(-?\d+\.?\d*)/", $url, $matches)) {
            return $this->formatCoordinates($matches[1], $matches[2]);
        }

        // Pattern 13: URL encoded coordinates with %2B (plus sign)
        if (preg_match("/(-?\d+\.?\d*),%2B(-?\d+\.?\d*)/", $url, $matches)) {
            return $this->formatCoordinates($matches[1], $matches[2]);
        }

        // Pattern 14: URL encoded coordinates with + sign
        if (preg_match("/(-?\d+\.?\d*),\+(-?\d+\.?\d*)/", $url, $matches)) {
            return $this->formatCoordinates($matches[1], $matches[2]);
        }

        return null;
    }

    /**
     * Follow redirects to get final URL - improved for goo.gl URLs
     */
    private function followRedirects(string $url): string
    {
        try {
            // For goo.gl URLs, we need to actually make a GET request to follow redirects
            $isShortUrl = str_contains($url, 'goo.gl') || str_contains($url, 'maps.app.goo.gl');

            if ($isShortUrl) {
                // Use GET with a small content limit for short URLs
                $response = Http::timeout(15)
                    ->withOptions([
                        'allow_redirects' => [
                            'max' => 10,
                            'strict' => false,
                            'referer' => true,
                            'track_redirects' => true
                        ],
                        'headers' => [
                            // Use a German user agent to match the consent page
                            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                            'Accept-Language' => 'en-US,en;q=0.9',
                            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8'
                        ],
                        'stream' => true,
                        'read_timeout' => 15,
                        'connect_timeout' => 10
                    ])
                    ->get($url);

                // Get the final URL from the response
                $finalUrl = $response->effectiveUri();
                if ($finalUrl && (string)$finalUrl !== $url) {
                    Log::info('Successfully followed redirect', [
                        'original' => $url,
                        'final' => (string)$finalUrl
                    ]);
                    return (string)$finalUrl;
                }
            } else {
                // For regular URLs, use HEAD request
                $response = Http::timeout(10)
                    ->withOptions([
                        'allow_redirects' => [
                            'max' => 5,
                            'strict' => true,
                            'referer' => false,
                            'track_redirects' => false
                        ],
                        'headers' => [
                            'User-Agent' => 'Mozilla/5.0 (compatible; LocationBot/1.0)'
                        ]
                    ])
                    ->head($url);

                $finalUrl = $response->effectiveUri();
                if ($finalUrl && (string)$finalUrl !== $url) {
                    return (string)$finalUrl;
                }
            }

        } catch (\Exception $e) {
            Log::info('Could not follow redirects, using original URL', [
                'url' => $url,
                'error' => $e->getMessage()
            ]);
        }

        return $url;
    }

    /**
     * Format and validate coordinates
     */
    private function formatCoordinates(string $lat, string $lng): array
    {
        // Clean up the coordinates (remove + signs, spaces, etc.)
        $lat = str_replace(['+', ' '], '', trim($lat));
        $lng = str_replace(['+', ' '], '', trim($lng));

        $latitude = (float)$lat;
        $longitude = (float)$lng;

        // Basic coordinate validation
        if ($latitude < -90 || $latitude > 90) {
            throw new \Exception('عرض جغرافیایی نامعتبر: ' . $latitude);
        }

        if ($longitude < -180 || $longitude > 180) {
            throw new \Exception('طول جغرافیایی نامعتبر: ' . $longitude);
        }

        // Check for obviously invalid coordinates (0,0 or very close to 0)
        if (abs($latitude) < 0.001 && abs($longitude) < 0.001) {
            throw new \Exception('مختصات نامعتبر (احتمالاً 0,0)');
        }

        // Validate coordinates are within Iran boundaries
        if (!$this->isWithinIran($latitude, $longitude)) {
            throw new \Exception('مختصات وارد شده خارج از محدوده ایران است');
        }

        return [
            'coordinates' => number_format($latitude, 6) . ',' . number_format($longitude, 6),
            'latitude' => $latitude,
            'longitude' => $longitude,
            'formatted_lat' => number_format($latitude, 6),
            'formatted_lng' => number_format($longitude, 6),
        ];
    }

    /**
     * Check if coordinates are within Iran boundaries
     */
    private function isWithinIran(float $lat, float $lng): bool
    {
        // Iran boundaries (slightly more precise)
        $iranBounds = [
            'north' => 39.782,
            'south' => 25.078,
            'east' => 63.317,
            'west' => 44.047
        ];

        return $lat >= $iranBounds['south'] &&
            $lat <= $iranBounds['north'] &&
            $lng >= $iranBounds['west'] &&
            $lng <= $iranBounds['east'];
    }

    /**
     * Validate coordinates without URL (utility method)
     */
    public function validateCoordinates(float $lat, float $lng): bool
    {
        try {
            $this->formatCoordinates((string)$lat, (string)$lng);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Test URL patterns (for debugging/testing)
     */
    public function testUrlPatterns(): array
    {
        $testUrls = [
            'https://maps.app.goo.gl/4F7JSHCXGYrPZKbb9', // Your test URL
            'https://maps.app.goo.gl/ABC123',
            'https://maps.google.com/maps?q=35.6892,51.3890',
            'https://www.google.com/maps/@35.6892,51.3890,15z',
            'https://maps.google.com/maps?ll=35.6892,51.3890',
            'https://maps.google.com/maps?center=35.6892,51.3890',
            'https://www.google.com/maps/place/Tehran/@35.6892,51.3890',
            'https://goo.gl/maps/abc123',
            'maps.google.com/@35.6892,51.3890'
        ];

        $results = [];
        foreach ($testUrls as $url) {
            try {
                $coords = $this->extractCoordinatesFromUrl($url);
                $results[$url] = $coords;
            } catch (\Exception $e) {
                $results[$url] = ['error' => $e->getMessage()];
            }
        }

        return $results;
    }

    /**
     * Debug method to test redirect following and extraction
     */
    public function debugExtraction(string $url): array
    {
        $normalized = $this->normalizeUrl($url);
        $finalUrl = $this->followRedirects($normalized);

        $debug = [
            'original' => $url,
            'normalized' => $normalized,
            'final_url' => $finalUrl,
            'is_consent' => str_contains($finalUrl, 'consent.google.com'),
        ];

        if (str_contains($finalUrl, 'consent.google.com')) {
            $debug['consent_extraction'] = $this->extractFromConsentUrl($finalUrl);
        }

        $debug['direct_extraction'] = $this->extractFromDirectUrl($finalUrl);

        return $debug;
    }
}
