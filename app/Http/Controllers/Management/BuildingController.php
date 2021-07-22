<?php
/** 
 * Buildings Controller
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
 *  Building controller Extend controller Classe
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param RealState $company Company id
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RealState $company)
    {
        
        return view('management.building', compact('company'));
    }
}
