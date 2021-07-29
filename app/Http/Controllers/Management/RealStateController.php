<?php
/**
 * Company Controller
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
 *  Company controller extends Controller Classe
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
     * @param RealState $company company id
     *
     * @return \Illuminate\Http\Response
     */
    public function profile(RealState $company)
    {
        return view('management.realstate', compact('company'));
    }
}
