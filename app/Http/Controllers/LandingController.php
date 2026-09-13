<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Foundation\Application;
use Illuminate\Support\Carbon;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $ip = $request->ip();
        $userAgent = (string) $request->userAgent();

        return view('landing', [
            'ip' => $ip,
            'ips' => array_values(array_unique($request->ips())),
            'ipVersion' => filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ? 'IPv6' : 'IPv4',
            'isPrivateIp' => ! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE),
            'forwardedFor' => $request->header('X-Forwarded-For'),
            'userAgent' => $userAgent,
            'browser' => $this->browser($userAgent),
            'os' => $this->os($userAgent),
            'deviceType' => $this->deviceType($userAgent),
            'isBot' => (bool) preg_match('/bot|crawl|spider|slurp|curl|wget|postman|python-requests/i', $userAgent),
            'acceptLanguage' => $request->header('Accept-Language'),
            'referrer' => $request->header('Referer'),
            'doNotTrack' => $request->header('DNT'),
            'method' => $request->method(),
            'scheme' => $request->getScheme(),
            'host' => $request->getHost(),
            'port' => $request->getPort(),
            'protocol' => $request->server('SERVER_PROTOCOL'),
            'isSecure' => $request->isSecure(),
            'serverTime' => Carbon::now(),
            'serverTimezone' => config('app.timezone'),
            'utcTime' => Carbon::now('UTC'),
            'unixTime' => Carbon::now()->getTimestamp(),
            'phpVersion' => PHP_VERSION,
            'laravelVersion' => Application::VERSION,
            'serverSoftware' => $request->server('SERVER_SOFTWARE') ?: php_sapi_name(),
            'osFamily' => PHP_OS_FAMILY,
        ]);
    }

    /**
     * Serve random bytes so the client can measure real download throughput.
     */
    public function speedtestDownload(Request $request)
    {
        $bytes = (int) $request->query('bytes', 1_000_000);
        $bytes = max(1_000, min($bytes, 25_000_000));

        return new Response(random_bytes($bytes), 200, [
            'Content-Type' => 'application/octet-stream',
            'Content-Length' => $bytes,
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
        ]);
    }

    /**
     * Accept an upload body and report how many bytes landed, for upload throughput.
     */
    public function speedtestUpload(Request $request)
    {
        return response()->json([
            'bytes' => strlen($request->getContent()),
        ])->header('Cache-Control', 'no-store');
    }

    /**
     * Tiny endpoint used to measure round-trip latency.
     */
    public function ping()
    {
        return response()->json(['t' => microtime(true)])
            ->header('Cache-Control', 'no-store');
    }

    private function browser(string $ua): string
    {
        return match (true) {
            (bool) preg_match('/Edg\//i', $ua) => 'Edge',
            (bool) preg_match('/OPR\/|Opera/i', $ua) => 'Opera',
            (bool) preg_match('/Firefox\//i', $ua) => 'Firefox',
            (bool) preg_match('/Chrome\//i', $ua) => 'Chrome',
            (bool) preg_match('/Safari\//i', $ua) => 'Safari',
            default => 'Unknown',
        };
    }

    private function os(string $ua): string
    {
        return match (true) {
            (bool) preg_match('/Windows NT/i', $ua) => 'Windows',
            (bool) preg_match('/iPhone|iPad|iPod/i', $ua) => 'iOS',
            (bool) preg_match('/Mac OS X/i', $ua) => 'macOS',
            (bool) preg_match('/Android/i', $ua) => 'Android',
            (bool) preg_match('/Linux/i', $ua) => 'Linux',
            default => 'Unknown',
        };
    }

    private function deviceType(string $ua): string
    {
        return match (true) {
            (bool) preg_match('/iPad|Tablet/i', $ua) => 'Tablet',
            (bool) preg_match('/Mobile|iPhone|Android/i', $ua) => 'Mobile',
            default => 'Desktop',
        };
    }
}
