<?php

namespace App\Http\Middleware;

use Closure;

class Mid_auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Cookie::get('mcul_token') === null) {
            return redirect('login')->with('status', 'Permission Denied');
        } else {
            $role_id = \Cookie::get('mcul_role');
            // 2 reply 3 report
            $reply = ['ReplyController'];
            $report = ['MakeReportController', 'ReportUserController'];
            $all = ['KmFolkartController', 'KmRitualsController', 'KmThailitdirController', 'KmTraditionController','AdminProfileController'];
            $controller = class_basename(\Route::current()->controller);
            if ($role_id == 2) {
                if (!in_array($controller, array_merge($reply, $all))) {
                    return redirect('login')->with('status', 'Permission Denied Pls. Login another user')->withCookie(\Cookie::forget('mcul_token'))->withCookie(\Cookie::forget('mcul_role'));
                }
            } elseif ($role_id == 3) {
                if (!in_array($controller, array_merge($report, $all))) {
                    return redirect('login')->with('status', 'Permission Denied Pls. Login another user')->withCookie(\Cookie::forget('mcul_token'))->withCookie(\Cookie::forget('mcul_role'));
                }
            }
        }
        return $next($request);
    }
}
