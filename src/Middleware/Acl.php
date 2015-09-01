<?php

namespace Codebank\Acl\Middleware;

use Closure;
use Codebank\Acl\Models\AclUserRole;

class Acl {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Get the required roles from the route
        $permission = $request->route()->getAction()['permission'];
        $module     = $permission['module'] ? $permission['module'] : null;
        $action     = $permission['action'] ? $permission['action'] : null;
        
        if (\Auth::user())
        {
            \Config::set('view.permission', AclUserRole::getPermissions());
        }

        if ($request->user()->checkPermission($module, $action))
        {
            return $next($request);
        }

        return redirect('unauthorized');
    }

}
