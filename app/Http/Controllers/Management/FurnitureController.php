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
use App\Models\Apartment;
use App\Models\Furniture;
use App\Models\RealState;
use Illuminate\Support\Facades\DB;

/**
 *  Furniture controller extend controller
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
     * @param RealState $company company id
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(RealState $company)
    {
        $company = $company->load('furnitures', 'furnitures.furnitureType');

        $furnitures = $company->furnitures->map( 
            function ($furniture) {
                $furniture['code'] = $furniture['id'].$furniture['furniture_type_id'].$furniture['real_state_id'];
                return $furniture;
            }
        );

        return view('management.furniture', compact('company', 'furnitures'));
    }
    
    /**
     * Show furniture detais
     *
     * @param RealState $company   company id
     * @param Furniture $furniture furniture
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(RealState $company, Furniture $furniture)
    {
        $furniture = $furniture->load('apartments.building', 'furnitureType');
        $furnitureAssignement = $furniture->furnitureAssigned();

        //dd($company);

        return view('management.furniture-show', compact('company', 'furniture', 'furnitureAssignement'));
    }
    
    /**
     * Withdraw furniture from apartment
     *
     * @param \Illuminate\Http\Request $request   Request
     * @param RealState                $company   Company ID
     * @param App\Models\Furniture     $furniture Furniture
     * @param App\Models\Apartment     $apartment Apartment
     * 
     * @return Illuminate\Http\RedirectResponse
     */
    public function withdraw(Request $request, RealState $company, Furniture $furniture, Apartment $apartment)
    {
        //dd($request->assigned_at);
        $validatedData = $request->validate(
            [
                'assigned_at' => 'required|date|before_or_equal:today'
            ]
        );

        $furniture->apartments()->updateExistingPivot($apartment, ['withdraw_at'=>now()]);

        return redirect()->route('company.furnitures.show', ['company'=>$company, 'furniture'=>$furniture])->with('status', 'Withdraw updated successfuly');
        
    }
    
    /**
     * Salvage
     *
     * @param \Illuminate\Http\Request $request Request
     * 
     * @return \Illuminate\Http\Response
     */
    public function salvage(Request $request)
    {
        
        if ($request->ajax()) {
            $msgType = null;
            $msg = null;
            $code = null;
            $request->validate(
                [
                    'furniture_id' => 'required|numeric|exists:furniture,id',
                    'company_id'=> 'required|numeric|exists:real_states,id'
                ]
            );

            DB::beginTransaction();
            try {
                
                $furniture = Furniture::where('id', $request->furniture_id)->first();

                $furniture->salvage_at = now();
                
                $furniture->save();
                
                $closeAssigned = $furniture->furnitureAssigned();

                if (!empty($closeAssigned)) {
                    DB::table('furniture_apartment')
                        ->where('id', $closeAssigned->id)
                        ->update(['withdraw_at'=>now()]);
                }
                
                DB::commit();
                
                $msgType = "success";
                $msg = "Salvage completed successfuly";
                $code = 200;
            } catch (\Exception $ex) {
                DB::rollBack();
                $msgType = "error";
                $msg = $ex->getMessage();
                $code = 422;
            }

            return response()->json(['type'=>$msgType, 'message'=> $msg], $code);
        }

        return null;
    }
    
    /**
     * Delete furniture
     *
     * @param \Illuminate\Http\Request $request Request
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            
            $request->validate(
                [
                    'furniture_id' => 'required|numeric|exists:furniture,id',
                    'company_id'=> 'required|numeric|exists:real_states,id'
                ]
            );

            DB::table('furniture')->where('id', $request->furniture_id)->delete();

            return response()->json(['type'=>'success', 'message'=> 'Furniture deleted successfully'], 200);
        }
        return null;
    }
    
    
}
