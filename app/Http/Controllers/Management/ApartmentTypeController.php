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
use Illuminate\Support\Facades\Validator;
use Laratrust\LaratrustFacade;

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
     * @param \Illuminate\Http\Request $request Request
     * @param RealState                $company Company
     *
     * @return View
     */
    public function index(Request $request, RealState $company)
    {
        if ($request->ajax()) {
            $company = $company->load('apartmentTypes.apartments');
            $apartmentTypes = $company->apartmentTypes;

            return datatables()->of($apartmentTypes)
                ->addIndexColumn()
                ->editColumn(
                    'created_at',
                    function ($request) {
                        return $request->created_at->format('d F Y');
                    }
                )
                ->addColumn(
                    'action',
                    function ($apartmentTypes) {
                        $btn = '<nobr>';
                        $btn = $btn.'<a class="btn btn-outline-primary btn-sm mx-1 shadow" type="button" title="More details" href="#"><i class="fas fa-info-circle fa-fw"></i></a>';
                        if (LaratrustFacade::isAbleTo('furnitureType-update')) {
                            $btn = $btn.'<button class="btn btn-outline-secondary mx-1 shadow btn-sm editApartmentTypeButton" type="button" title="Edit Furniture Type" value="'.$apartmentTypes->id.'"><i class="fas fa-pencil-alt fa-fw"></i></button>';
                        }
                        if (LaratrustFacade::isAbleTo('furnitureType-delete') && $apartmentTypes->apartments->count()==0) {
                            $btn = $btn.'<button class="btn btn-outline-danger mx-1 shadow btn-sm deleteApartmentTypeButton" title="Delete Furniture Type" type="button" value="'.$apartmentTypes->id.'"><i class="fas fa-trash-alt fa-fw"></i></button>';
                        }
                        $btn = $btn.'</nobr>';
                        return $btn;
                    }
                )
                ->removeColumn('id')
                ->removeColumn('real_state_id')
                ->removeColumn('updated_at')
                ->make();

        }


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


        $validator = Validator::make(
            $request->all(),
            [
                'apart_type_id' => ['nullable', 'numeric', 'exists:apartment_types,id'],
                'real_state_id' => ['required', 'numeric', 'exists:real_states,id'],
                'name'=>['required', 'string','min:6','max:32','regex:/^[a-z ,.\'-]+$/i'],
                'tag'=>['required'],
                'description'=>['nullable', 'string', 'min:3', 'max:191']
            ]
        );

        if ($validator->fails()) {
            return redirect()->route(
                'company.apartment-setting',
                [
                    'company'=>$company
                ]
            )->withErrors($validator)->withInput();
        }

        ApartmentType::updateOrCreate(
            ['tag'=> $request->tag, 'real_state_id' => $request->real_state_id],
            [
                'name' => $request->name,
                'description' => $request->description,
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
     * @param \Illuminate\Http\Request $request Request
     * @param RealState                $company Company
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, RealState $company)
    {
        if ($request->ajax()) {

            $request->validate(
                [
                    'apartment_type_id'=>['required', 'numeric', 'exists:apartment_types,id']
                ]
            );

            $myapartmentType = ApartmentType::find($request->apartment_type_id);

            return response()->json(['type'=>"success", 'apartment_type'=>$myapartmentType], 200);
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
     * @param RealState                $company Company
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, RealState $company)
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
