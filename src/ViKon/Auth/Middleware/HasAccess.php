<?php

namespace ViKon\Auth\Middleware;

use Closure;
use Illuminate\Auth\Guard;
use Illuminate\Routing\Router;
use ViKon\Auth\AuthUser;

/**
 * Class HasAccess
 *
 * @package ViKon\Auth\Middleware
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class HasAccess
{
    /** @var \Illuminate\Routing\Router */
    protected $router;

    /** @var \Illuminate\Auth\Guard */
    protected $guard;

    /** @var \ViKon\Auth\AuthUser */
    protected $authUser;

    /**
     * @param \Illuminate\Routing\Router $router
     * @param \Illuminate\Auth\Guard     $guard
     * @param \ViKon\Auth\AuthUser       $authUser
     */
    public function __construct(Router $router, Guard $guard, AuthUser $authUser)
    {
        $this->router   = $router;
        $this->guard    = $guard;
        $this->authUser = $authUser;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        $action = $this->router->current()
                               ->getAction();

        if (array_key_exists('roles', $action)) {
            if (!$this->guard->check()) {
                return redirect()->guest(route(config('auth-role.login.route')));
            } elseif (!$this->authUser->hasRoles($action['roles'])) {
                return redirect()
                    ->route(config('auth-role.error-403.route'))
                    ->with('route-request-uri', $request->getRequestUri())
                    ->with('route-roles', $action['roles']);
            }
        }

        return $next($request);
    }
}