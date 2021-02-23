<?php
/** 
 * Laratrust Roles Component
 * 
 * PHP version 7.4
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
namespace App\Http\Controllers\Management;
use App\Http\Controllers\Controller;
use App\Models\RealState;
use Illuminate\Http\Request;
/**
 *  Extended Laratrust Roles Classe
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class RealStateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.clients');
    }

    /**
     * Display Real estate profile.
     *
     * @param $id company id
     * 
     * @return \Illuminate\Http\Response
     */
    public function profile($id)
    {
        $company = RealState::findOrFail($id);

        return view('management.realstate', compact('company'));
    }
}
