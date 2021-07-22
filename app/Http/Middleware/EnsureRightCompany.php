<?php
/** 
 * Ensure rigth company middleware
 * 
 * PHP version 7.4
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Laratrust\LaratrustFacade;

/**
 *  Ensure rigth company Class
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class EnsureRightCompany
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request Request
     * @param \Closure                 $next    Next
     * 
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!LaratrustFacade::hasRole('superadministrator')) {
            if ($request->session()->get('companyID') != $request->route('company')->id) {
                return abort('403', 'You dont have the necessary rigth to access this page');
            }
        }
        return $next($request);
    }
}
