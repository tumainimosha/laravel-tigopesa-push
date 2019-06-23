<?php

namespace Tumainimosha\TigopesaPush\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\IpUtils;

class IpAddressFilter
{
    /**
     * List of valid IPs.
     *
     * @var array
     */
    protected $whitelist_ips = [];


    public function __construct()
    {
        // Get whitelisted ips from config
        $this->whitelist_ips = config('tigopesa-push.whitelist_ips', []);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        foreach ($request->getClientIps() as $ip) {
            if (! $this->isValidIp($ip) && ! $this->isValidIpRange($ip)) {
                throw new AuthorizationException();
            }
        }

        return $next($request);
    }

    /**
     * Check if the given IP is valid.
     *
     * @param $ip
     * @return bool
     */
    protected function isValidIp($ip)
    {
        return in_array($ip, $this->whitelist_ips);
    }

    /**
     * Check if the ip is in the given IP-range.
     *
     * @param $ip
     * @return bool
     */
    protected function isValidIpRange($ip)
    {
        return IpUtils::checkIp($ip, $this->whitelist_ips);
    }
}
