<?php
/** 
 * Apartment Type Controller
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
use App\Models\ApartmentType;
use App\Models\RealState;
use Illuminate\Http\Request;
/**
 *  Apartment Type controller main Class
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class ApartmentTypeController extends Controller
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
        $company = $company->load('apartmentTypes.apartments');

        return view('admin.apartments-type', compact('company'));
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

        
        $validatedData = $request->validate( 
            [
                'real_state_id' => ['required', 'numeric', 'exists:real_states,id'],
                'name'=>['required', 'string','min:6','max:32','regex:/^[a-z ,.\'-]+$/i'],
                'tag'=>['required'],
                'description'=>['nullable', 'string', 'min:3', 'max:191']
            ]
        );
        //dd($request);
        $apartmentType = ApartmentType::updateOrCreate(
            ['tag'=> $validatedData['tag'], 'real_state_id' => $validatedData['real_state_id']],
            [
                'name' => $validatedData['name'],
                'description' => $validatedData['description']
            ]
        );

        return redirect()->route('company.apartment-setting', ['company'=>$company])->with('success', 'Apartment type created succesfully');
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
     * @param \Illuminate\Http\Request $request     Request
     * @param int                      $id          ID
     * @param int                      $apartTypeId Apart Type ID
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, int $id, int $apartTypeId)
    {
        if ($request->ajax()) {
            
            $request->validate(
                [
                    'company_id'=>['required', 'numeric', 'exists:real_states,id'],
                    'apartment_type_id'=>['required', 'numeric', 'exists:apartment_types,id']
                ]
            );

            $apartmentType = ApartmentType::find($request->apartment_type_id);

            return response()->json(['type'=>"success", 'apartment_type'=>$apartmentType], 200);
        }
        return null;
        
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
     * @param \Illuminate\Http\Request $request Request
     * @param int                      $id      ID
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, int $id)
    {
        if ($request->ajax()) {
            $request->validate(
                [
                    'apartment_type_id'=> ['required', 'numeric', 'exists:apartment_types,id']
                ]
            );
            
            ApartmentType::destroy($request->apartment_type_id);

            return response()->json(['type'=>"success", 'message'=>"Deleted successfully"], 200);
        }
    }
}
