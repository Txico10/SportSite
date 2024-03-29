<?php
/**
 * The User Controller
 *
 * PHP version 7.4
 *
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Team;
use App\Rules\PermissionRolesCheck;
use Illuminate\Support\Facades\DB;
use Laratrust\LaratrustFacade;

/**
 *  The User controller main Class
 *
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */

class UserController extends Controller
{

    /**
     * Show the list of users
     *
     * @param Request $request Request
     *
     * @return Illuminate\Support\Facades\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if (LaratrustFacade::hasRole('administrator')) {

                $users= User::select(['users.*', 'roles.display_name AS role_name', 'teams.display_name AS team_name'])
                    ->join('role_user', 'role_user.user_id', '=', 'users.id')
                    ->join('roles', 'role_user.role_id', '=', 'roles.id')
                    ->join('teams', 'role_user.team_id', '=', 'teams.id')
                    ->where('teams.name', '=', $request->session()->get('companyID'))
                    ->withLastLoginDate()
                    ->orderBy('users.name', 'asc')
                    ->get();
            } else {
                $roles_teams = DB::table('role_user')
                    ->select(['roles.display_name AS role_name', 'role_user.user_id AS userID', 'teams.display_name AS team_name'])
                    ->join('roles', 'role_user.role_id', '=', 'roles.id')
                    ->leftJoin('teams', 'role_user.team_id', '=', 'teams.id');

                $users = User::select(['users.*', 'roles_teams.role_name', 'roles_teams.team_name'])
                    ->leftJoinSub(
                        $roles_teams,
                        'roles_teams',
                        function ($join) {
                            $join->on('users.id', '=', 'roles_teams.userID');
                        }
                    )
                    ->withLastLoginDate()
                    ->orderBy('users.name', 'asc')
                    //->limit(3)
                    ->get();
            }

            return datatables()->of($users)
                ->addIndexColumn()
                ->editColumn(
                    'last_login_at',
                    function ($request) {
                        return !empty($request->last_login_at)?$request->last_login_at->format('d F Y'):'Never';
                    }
                )
                ->editColumn(
                    'role_name',
                    function ($request) {
                        return '<span class="badge bg-success">'.$request->role_name.'</span>';
                    }
                )
                ->addColumn(
                    'action',
                    function ($user) {
                        $btn = '<nobr>';
                        $btn = '<a class="btn btn-sm btn-outline-primary mx-1 shadow" type="button" title="More details" href="'.route('admin.users.show', ['user'=>$user]).'"><i class="fas fa-user-cog fa-fw"></i></a>';
                        if (Auth::id()!=$user->id) {
                            if (LaratrustFacade::isAbleTo('users-delete') && !$user->hasRole('superadministrator')) {
                                $btn = $btn.'<button class="btn btn-sm btn-outline-danger mx-1 shadow userDelete" type="button" value="'.$user->id.'" title="Delete User"><i class="fas fa-trash-alt fa-fw"></i></button>';
                            }
                            if ($user->status==0) {
                                $btn = $btn.'<button class="btn btn-sm btn-outline-secondary mx-1 shadow changeStatus" type="button" value = "'.$user->id.'" title="Inactive User"><i class="fas fa-toggle-off fa-fw"></i></button>';
                            } else {
                                $btn = $btn.'<button class="btn btn-sm btn-outline-success mx-1 shadow changeStatus" type="button" value = "'.$user->id.'" title="Active User"><i class="fas fa-toggle-on fa-fw"></i></button>';
                            }
                        }

                        $btn = $btn.'</nobr>';

                        return $btn;
                    }
                )
                ->rawColumns(['role_name', 'action'])
                ->removeColumn('id')
                ->removeColumn('email_verified_at')
                ->removeColumn('password')
                ->removeColumn('status')
                ->removeColumn('image')
                ->removeColumn('api_token')
                ->removeColumn('remember_token')
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->make();

        }

        //dd($users);
        return view('admin.users');
    }

    /**
     * Create new User
     *
     * @param Request $request route request
     *
     * @return Illuminate\Support\Facades\View
     */
    public function create(Request $request)
    {
        return view('admin.users-create');
    }

    /**
     * Show user
     *
     * @param Request $request route request
     * @param User    $user    User informations
     *
     * @return Illuminate\Support\Facades\View
     */
    public function show(Request $request, User $user)
    {
        if ($request->ajax()) {
            $logins = DB::table('logins')
                ->where('user_id', $user->id)
                ->select(['ip_address', 'created_at'])
                ->get();

            return datatables()->of($logins)
                ->addIndexColumn()
                ->editColumn(
                    'created_at',
                    function ($login) {
                        return \Carbon\Carbon::parse($login->created_at)->format('d F Y \- H:i:s');
                    }
                )
                ->make();
        }

        $user = $user->load('roles', 'permissions');
        $teamID = [];
        foreach ($user->roles as $key => $role) {
            array_push($teamID, $role->pivot->team_id);
        }
        $teams = Team::whereIn('id', $teamID)->get();
        return view('admin.users-show', compact('user', 'teams'));
    }
    /**
     * Show user profile
     *
     * @param User $user user id
     *
     * @return Illuminate\Support\Facades\View
     */
    public function profile(User $user)
    {
        //$user = User::with(['contact', 'employees.contact'])->findOrFail($id);
        //dd($user);
        if ($user->id != Auth::id()) {
            abort('403');
        } else {
            //dd($user);
            return view('user.profile', compact('user'));
        }

    }

    /**
     * Change Status
     *
     * @param Request $request Request
     * @param int     $id      User ID
     *
     * @return ajax
     */
    public function changeStatus(Request $request, int $id)
    {
        if ($request->ajax()) {
            $request->validate(
                [
                    'user_id' => 'required|numeric|exists:users,id',
                ]
            );

            $user= User::findOrFail($id);

            if ($user->status==User::ACTIVE) {
                $user->status = User::INACTIVE;
            } else {
                $user->status = User::ACTIVE;
            }
            $user->save();
            return response()->json(['type'=>"success", 'message'=> "User status updated successfully"], 200);
        }
        return null;
    }

    /**
     * Get Roles
     *
     * @param Request $request Request
     * @param User    $user    User
     *
     * @return Response json
     */
    public function getRoles(Request $request, User $user)
    {
        if ($request->ajax()) {

            $search = $request->search;

            //$user = User::findOrFail($id);

            //$userPermissions = $user->permissions;

            if ($search == '') {
                $roles = Role::select('id', 'display_name')
                    ->where('id', '<>', 1)
                    ->limit(5)
                    ->get();
            } else {
                $roles = Role::select('id', 'display_name')
                    ->where('id', '<>', 1)
                    ->where('display_name', 'like', '%'.$search.'%')
                    ->limit(10)
                    ->get();
            }

            $response = array();

            foreach ($roles as $role) {
                $response[] = array(
                    'id' => $role->id,
                    'text' => $role->display_name,
                );
                /*
                if ($userPermissions->contains('name', $permission->name)) {
                    $response[] = array(
                        'id' => $permission->id,
                        'text' => $permission->display_name,
                        'selected' => true
                    );
                } else {

                }
                */
            }

            return response()->json($response, 200);
        }
        return null;
    }

    /**
     * Permissions list
     *
     * @param Request $request Request
     * @param User    $user    User
     *
     * @return Response json
     */
    public function getPermissions(Request $request, User $user)
    {
        if ($request->ajax()) {

            $search = $request->search;

            //$user = User::findOrFail($id);

            //$userPermissions = $user->permissions;

            if ($search == '') {
                $permissions = Permission::select('id', 'display_name')
                    ->limit(6)
                    ->get();
            } else {
                $permissions = Permission::select('id', 'display_name')
                    ->where('display_name', 'like', '%'.$search.'%')
                    ->limit(6)
                    ->get();
            }

            $response = array();

            foreach ($permissions as $permission) {
                $response[] = array(
                    'id' => $permission->id,
                    'text' => $permission->display_name,
                );
            }

            return response()->json($response, 200);
        }
        return null;
    }

    /**
     * Fill User Roles and Profiles
     *
     * @param Request $request Request
     * @param User    $user    User ID
     *
     * @return Response json
     */
    public function fillRolesProfiles(Request $request, User $user)
    {
        if ($request->ajax()) {
            $request->validate(
                [
                    'team_id' => 'required|numeric|exists:teams,id',
                ]
            );

            $myteam_id = $request->team_id;

            $myteam = Team::findOrFail($request->team_id);

            $myroles = $user->roles->filter(
                function ($value, $key) use ($myteam_id) {
                    if ($value->pivot->team_id == $myteam_id) {
                        return $value;
                    }
                }
            );

            $mypermissions = $user->permissions->filter(
                function ($value, $key) use ($myteam_id) {
                    if ($value->pivot->team_id == $myteam_id) {
                        return $value;
                    }
                }
            );

            $roles = array();
            foreach ($myroles as $myrole) {
                $roles[] = array(
                    'id' => $myrole->id,
                    'text' => $myrole->display_name,
                    'selected' => true
                );
            }

            $permissions = array();
            foreach ($mypermissions as $mypermission) {
                $permissions[] = array(
                    'id' => $mypermission->id,
                    'text' => $mypermission->display_name,
                    'selected' => true
                );
            }

            $team = array(
                'id' => $myteam->id,
                'name' => $myteam->display_name,
            );

            return response()->json(['type'=>'success', 'team'=>$team, 'roles'=> $roles, 'permissions'=> $permissions], 200);
        }
        return null;
    }

    /**
     * Update Roles and Permissions
     *
     * @param Request $request Request
     * @param User    $user    User ID
     *
     * @return void
     */
    public function updateRolesPermissions(Request $request, User $user)
    {
        if ($request->ajax()) {

            $request->validate(
                [
                    //'user_id'=>['required','numeric','exists:users,id'],
                    'team_id'=>['required','numeric','exists:teams,id'],
                    'roles'=>['required','array','min:1','exists:roles,id'],
                    'permissions'=>[
                            'sometimes','array', 'min:1', 'exists:permissions,id',
                            new PermissionRolesCheck($request->roles)
                        ]
                ]
            );

            //$user = User::find($request->user_id);
            $user->syncRoles($request->roles, $request->team_id);

            $mypermissions = $user->permissions;

            if (empty($request->permissions)) {
                if ($mypermissions->count()>0) {
                    $user->detachPermissions($mypermissions, $request->team_id);
                }
            } else {
                if ($mypermissions->count()>0) {
                    $user->syncPermissions($request->permissions, $request->team_id);
                } else {
                    $user->attachPermissions($request->permissions, $request->team_id);
                }

            }

            $msg="Roles and permissions updated successfuly!!!";

            return response()->json(["type"=>"success", "message"=>$msg]);
        }
        return null;
    }

    /**
     * Destroy
     *
     * @param Request $request Http Request
     * @param int     $id      User ID
     *
     * @return Response|null
     */
    public function destroy(Request $request, int $id)
    {
        if ($request->ajax()) {

            $request->validate(
                [
                    'user_id' => 'required|numeric|exists:users,id',
                ]
            );

            DB::beginTransaction();
            try {

                $user = User::find($request->user_id);

                $user_employees = DB::table('employee_contracts')
                    ->distinct()
                    ->where('user_id', $user->id)
                    ->select('employee_id AS id')
                    ->get();

                if ($user_employees->count()>0) {

                    foreach ($user_employees as $value) {
                        $employee = Employee::findOrFail($value->id);
                        $employee->contact->delete();
                        $employee->delete();
                    }

                }


                $permissions = $user->permissions;
                if ($permissions->count()>0) {
                    $user->detachPermissions($permissions);
                    //$msg = $msg." Etapa2";
                }

                $roles = $user->roles;
                $user->detachRoles($roles);


                $user->delete();
                //$msg = $msg." Etapa3";

                DB::commit();

                $msgType = "success";
                $msg = "User deleted successfully";
                $code = 200;
            } catch (\Throwable $th) {
                DB::rollBack();
                $msgType = "error";
                $msg = $th->getMessage();
                $code = 422;
            }

            return response()->json(['type'=>$msgType, 'message'=> $msg], $code);
        }
        return null;

    }
}
