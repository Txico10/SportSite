<?php
/**
 * Employees Controller
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
use App\Models\Employee;
use App\Models\RealState;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laratrust\LaratrustFacade;

/**
 *  Employee controller extend controller Classe
 *
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request   $request Request
     * @param RealState $company Company
     *
     * @return Illuminate\Support\Facades\View
     */
    public function index(Request $request, RealState $company)
    {
        //$employees = $company->employees;

        //dd($employees);
        if ($request->ajax()) {
            $employees = Employee::select(['employees.*', 'roles.display_name AS role_name'])
                ->join('employee_contracts', 'employee_contracts.employee_id', 'employees.id')
                ->join('roles', 'roles.id', 'employee_contracts.role_id')
                ->where('employee_contracts.real_state_id', $company->id)
                ->where('employee_contracts.end_date', '>=', now())
                ->orderBy('name', 'asc')
                ->get();

            return datatables()->of($employees)
                ->addIndexColumn()
                ->editColumn(
                    'gender',
                    function ($employee) {
                        return ucfirst($employee->gender);
                    }
                )
                ->editColumn(
                    'nas',
                    function ($employee) {
                        return empty($employee->nas)?"N/A":$employee->nas;
                    }
                )
                ->addColumn(
                    'action',
                    function ($employee) use ($company) {
                        $btn = '<nobr>';
                        $btn = $btn.'<a type="button" class="btn btn-sm btn-outline-primary mx-1 shadow" title="Employee profile" href="'.route('company.employees.show', ['company'=>$company, 'employee'=>$employee]).'"><i class="fas fa-fw fa-id-card"></i></a>';

                        if (LaratrustFacade::isAbleTo('employee-delete')) {
                            $btn = $btn.'<button class="btn btn-sm btn-outline-danger mx-1 shadow employeeDelete" type="button" value="'.$employee->id.'" title="Delete Employee"><i class="fas fa-trash-alt fa-fw"></i></button>';
                        }
                        $btn = $btn.'</nobr>';
                        return $btn;
                    }
                )
                ->make();
        }

        return view('management.employee', compact('company'));
    }

    /**
     * Create
     *
     * @param RealState $company company id
     *
     * @return \Illuminate\Http\Response
     */
    public function create(RealState $company)
    {
        //dd($company);

        return view('management.employee-create', compact('company'));
    }

    /**
     * Show
     *
     * @param Request   $request  Request
     * @param RealState $company  Company
     * @param Employee  $employee Employees
     *
     * @return Illuminate\Support\Facades\View
     */
    public function show(Request $request, RealState $company, Employee $employee)
    {

        if ($request->ajax()) {
            $contracts = DB::table('employee_contracts')
                ->join('roles', 'roles.id', 'employee_contracts.role_id')
                ->join('users', 'users.id', 'employee_contracts.user_id')
                ->where('employee_contracts.employee_id', $employee->id)
                ->where('employee_contracts.real_state_id', $company->id)
                ->select(['employee_contracts.id AS id','users.status AS user_status', 'roles.display_name AS role', 'employee_contracts.start_date AS start_date', 'employee_contracts.end_date AS end_date', 'employee_contracts.agreement AS agreement','employee_contracts.status AS status'])
                ->get();

            return datatables()->of($contracts)
                ->addIndexColumn()
                ->editColumn(
                    'user_status',
                    function ($contract) {
                        return $contract->user_status==1?'<span class="badge bg-success">Active</span>':'<span class="badge bg-danger">Inactive</span>';
                    }
                )
                ->editColumn(
                    'start_date',
                    function ($contract) {
                        return !is_null($contract->start_date)? \Carbon\Carbon::parse($contract->start_date)->format('d F Y'):'N/A';
                    }
                )
                ->editColumn(
                    'end_date',
                    function ($contract) {
                        return !is_null($contract->end_date)?\Carbon\Carbon::parse($contract->end_date)->format('d F Y'):'N/A';
                    }
                )
                ->editColumn(
                    'agreement',
                    function ($contract) {
                        return !is_null($contract->agreement)?'<span class="badge bg-success">Available</span>':'<span class="badge bg-danger">Not Available</span>';
                    }
                )
                ->editColumn(
                    'status',
                    function ($contract) {
                        return strcmp($contract->status, "FT")==0?"Full time": "Partial Time";
                    }
                )
                ->addColumn(
                    'action',
                    function ($contract) {
                        $btn = '<nobr>';
                        if ($contract->end_date>=now()) {
                            if (LaratrustFacade::isAbleTo(['employee_agreement-update']) && $contract->end_date > now()) {
                                $btn = $btn.'<button type="button" class="btn btn-sm btn-outline-info mx-1 shadow employeeUpdate" value="'.$contract->id.'" title="Edit Contract"><i class="fas fa-fw fa-pencil-alt"></i></button>';
                            }
                            if (LaratrustFacade::isAbleTo(['employee_agreement-delete'])) {
                                $btn = $btn.'<button type="button" class="btn btn-sm btn-outline-danger mx-1 shadow employeeDelete"  value="'.$contract->id.'" title="Terminate Contract"><i class="fas fa-fw fa-power-off"></i></button>';
                            }
                        }
                        if (!is_null($contract->agreement) && LaratrustFacade::isAbleTo(['employee_agreement-read'])) {
                            $btn =$btn.'<a class="btn btn-sm btn-outline-primary mx-1 shadow" type="button" title="Employee Agreement" href="#"><i class="fas fa-file-signature"></i></a>';
                        }
                        $btn=$btn.'</nobr>';
                        return $btn;
                    }
                )
                ->rawColumns(
                    [
                        'user_status', 'agreement', 'action'
                    ]
                )
                ->make();

        }

        //dd($employee->image);

        return view('management.employee-show', compact('company', 'employee'));
    }
}
