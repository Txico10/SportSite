<?php
/** 
 * Site Controller
 * 
 * PHP version 7.4
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/**
 *  Site controller class
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class SiteController extends Controller
{
    /**
     * Site frontpage
     * 
     * @return index
     */
    public function index() 
    {
        return view('welcome');
    }
}
