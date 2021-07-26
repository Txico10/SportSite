<?php
/** 
 * Furniture Type Controller
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
 *  Furniture Type controller main Class
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class FurnitureTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param RealState $company Company
     *
     * @return View
     */
    public function index(RealState $company)
    {
        $company = $company->loadMissing('furnitureTypes.furnitures');

        return view('admin.furnitures-type', compact('company'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request Request
     * @param RealState                $company Company
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, RealState $company)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id ID
     * 
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id ID
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request Request
     * @param int                      $id      ID
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id ID
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
