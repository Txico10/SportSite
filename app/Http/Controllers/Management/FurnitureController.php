<?php
/** 
 * Furniture Controller
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
use App\Models\RealState;

/**
 *  Furniture controller
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class FurnitureController extends Controller
{
    
    /**
     * Index
     *
     * @param int $id company id
     * 
     * @return void
     */
    public function index(int $id)
    {
        $company = RealState::where('id', $id)->first();
        //dd($furnitures);
        return view('management.furniture', compact('company'));
    }
}
