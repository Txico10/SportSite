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

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
/**
 *  Extended Laratrust Roles Classe
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class ApartmentController extends Controller
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
        
        return view('management.apartment', compact('id'));
    }
}
