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
use App\Models\FurnitureType;
use App\Models\RealState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laratrust\LaratrustFacade;

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
     * @param \Illuminate\Http\Request $request Request
     * @param RealState                $company Company
     *
     * @return View
     */
    public function index(Request $request, RealState $company)
    {

        if ($request->ajax()) {

            $company = $company->loadMissing('furnitureTypes.furnitures');
            $furnituresType = $company->furnitureTypes;

            return datatables()->of($furnituresType)
                ->addIndexColumn()
                ->editColumn(
                    'type',
                    function ($request) {
                        return $request->type==="A"?"Appliance":"Furniture";
                    }
                )
                ->editColumn(
                    'created_at',
                    function ($request) {
                        return $request->created_at->format('d F Y');
                    }
                )
                ->addColumn(
                    'action',
                    function ($furnituresType) {
                        $btn = '<a class="btn btn-outline-primary btn-sm mx-1 shadow" type="button" title="More details" href="#"><i class="fas fa-info-circle fa-fw"></i></a>';
                        if (LaratrustFacade::isAbleTo('furnitureType-update')) {
                            $btn = $btn.'<button class="btn btn-outline-secondary mx-1 shadow btn-sm editFurnitureTypeButton" type="button" title="Edit Furniture Type" value="'.$furnituresType->id.'"><i class="fas fa-pencil-alt fa-fw"></i></button>';
                        }
                        if (LaratrustFacade::isAbleTo('furnitureType-delete') && $furnituresType->furnitures->count()==0) {
                            $btn = $btn.'<button class="btn btn-outline-danger mx-1 shadow btn-sm deleteFurnitureTypeButton" title="Delete Furniture Type" type="button" value="'.$furnituresType->id.'"><i class="fas fa-trash-alt fa-fw"></i></button>';
                        }
                        return $btn;
                    }
                )
                ->removeColumn('id')
                ->removeColumn('real_state_id')
                ->removeColumn('updated_at')
                ->make();
        }

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
        $validator = Validator::make(
            $request->all(),
            [
                'furniture_types_id' => ['nullable', 'numeric', 'exists:furniture_types,id'],
                'real_state_id' => ['required', 'numeric', 'exists:real_states,id'],
                'furniture_types_type' => ['required', Rule::in(['A', 'F'])],
                'furniture_types_description' => ['nullable', 'string', 'min:3', 'max:191'],
            ]
        );

        if ($validator->fails()) {
            return redirect()->route(
                'company.furniture-setting',
                [
                    'company'=>$company
                ]
            )->withErrors($validator)->withInput();
        }

        //dd($request->all());

        FurnitureType::updateOrCreate(
            [
                'id'=>$request->furniture_types_id,
                'real_state_id'=>$request->real_state_id
            ],
            [
                'type'=>$request->furniture_types_type,
                'description'=> $request->furniture_types_description
            ]
        );

        return redirect()->route('company.furniture-setting', ['company'=>$company])->with('success', 'Furniture type created succesfully');

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
                    'furniture_type_id'=>['required', 'numeric', 'exists:furniture_types,id'],
                ]
            );
            $furniture_type = FurnitureType::find($request->furniture_type_id);
            return response()->json(['furniture_type'=>$furniture_type], 200);
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
     * @return \Illuminate\Http\Response json
     */
    public function destroy(Request $request, RealState $company)
    {
        if ($request->ajax()) {

            $request->validate(
                [
                    'furniture_type_id'=>['required', 'numeric', 'exists:furniture_types,id'],
                ]
            );

            FurnitureType::destroy($request->furniture_type_id);

            return response()->json(['type'=>"success", 'message'=>'Furniture type deleted successfully'], 200);
        }
        return null;
    }
}
