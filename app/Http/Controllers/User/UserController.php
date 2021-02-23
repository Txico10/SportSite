<?php
/** 
 * The User Controller
 * 
 * PHP version 7.4
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
/**
 *  The User controller main Class
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */

class UserController extends Controller
{
    /**
     * Show the list of users
     * 
     * @return users_view
     */
    public function index() 
    {
    
        return view('admin.users');
    }

    /**
     * Show user profile
     * 
     * @param $id user id 
     * 
     * @return users_view
     */
    public function profile($id) 
    {
        $user = User::findOrFail($id);
        if ($user->id != Auth::id()) {
            abort('403');
        } else {
            return view('user.profile', compact('user'));
        }
        
    }
}
