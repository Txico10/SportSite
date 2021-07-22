<?php
/** 
 * Employees Controller
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
 *  Employee controller extend controller Classe
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class EmployeeController extends Controller
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
        
        return view('management.employee', compact('company'));
    }
    
    /**
     * Create
     *
     * @param mixed $id company id
     * 
     * @return \Illuminate\Http\Response
     */
    public function create(RealState $company)
    {

        return view('management.employee-create', compact('company'));
    }
}
