<?php
/** 
 * Apartment Controller
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
use App\Models\Apartment;
use App\Models\RealState;

/**
 *  Apartment controller extend Controller Classe
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
     * @param RealState $company Company id
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RealState $company)
    {
        return view('management.apartment', compact('company'));
    }
    
    /**
     * Furniture List
     *
     * @param RealState $company   Company ID
     * @param Apartment $apartment Apartment
     * 
     * @return \Illuminate\Http\Response
     */
    public function furnitureList(RealState $company, Apartment $apartment)
    {
        $apartment = $apartment->load('apartmentType', 'building', 'furnitures', 'furnitures.furnitureType');
        //dd($apartment);
        return view('management.apartment-furniture', compact('company', 'apartment'));
    }
}
