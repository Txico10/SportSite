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
use App\Models\Apartment;
use App\Models\RealState;

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
        $company = RealState::where('id', $id)->first();
        return view('management.apartment', compact('company'));
    }
    
    /**
     * Furniture List
     *
     * @param int       $id        Company ID
     * @param Apartment $apartment Apartment
     * 
     * @return \Illuminate\Http\Response
     */
    public function furnitureList(int $id, Apartment $apartment)
    {
        $apartment = $apartment->load('apartmentType', 'building', 'furnitures', 'furnitures.furnitureType');
        //dd($apartment);
        return view('management.apartment-furniture', compact('id', 'apartment'));
    }
}
