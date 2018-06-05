<?php
namespace KemerovoMan\LoginVendor;

use Closure;
use Illuminate\Http\Request;

class IsAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (session('loginVendorRole') == 'admin') {
            return $next($request);
        } else {
            return redirect()
                ->action('\KemerovoMan\LoginVendor\LoginController@index', ['redirect_to' => $request->fullUrl()]);
        }
    }
}

