<?php
/**
 * Contract Type Controller
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
 *  Contract Type controller main Class
 *
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class ContractTypeController extends Controller
{

    /**
     * Index
     *
     * @param Request   $request Request
     * @param RealState $company Company
     *
     * @return Illuminate\Http\Response
     */
    public function index(Request $request, RealState $company)
    {
        return view('admin.contracts-type', compact('company'));
    }

    /**
     * Store
     *
     * @param Request   $request request
     * @param RealState $company Company
     *
     * @return Illuminate\Http\Response
     */
    public function store(Request $request, RealState $company)
    {
        dd($request->description);
    }
}
