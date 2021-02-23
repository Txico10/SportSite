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
class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param $id Company id
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        
        return view('management.building', compact('id'));
    }
}
