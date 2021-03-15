<?php
/** 
 * Livewire User Component
 * 
 * PHP version 7.4
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
namespace App\Http\Livewire\Admin;

use App\Models\Permission;
use App\Models\Role;
use App\Notifications\UserUpdate;
use App\Rules\PermissionRolesCheck;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;

/**
 *  Livewire Users component
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class UsersForm extends Component
{
    public $submit_btn_title = "Save";

    public $user_id;
    public $name;
    public $email;
    public $password;
    public $confirm_password;
    public $roles =[];
    public $permissions = [];
    public $allRoles;
    public $allPermissions;

    protected $listeners = [ 
                            'editUser'=>'edit',
                            'resetUserInputFields' => 'resetInputFields',
                           ];

    /**
     * Mount function
     * 
     * @return monted component
     */
    public function mount()
    {
        $this->allRoles = Role::all();
        $this->allPermissions = Permission::all();
    }
    /**
     * Render the livewire users form view
     * 
     * @return livewire_users
     */
    public function render()
    {
        return view(
            'livewire.admin.users-form',
            [
                'allRoles' => $this->allRoles,
                'allPermissions' => $this->allPermissions,
            ]
        );
    }

    
    /**
     * Rules validation
     * 
     * @return array rules
     */
    protected function rules()
    {
        return [
            'name'=>['required','string','min:6','max:32','regex:/^[a-z ,.\'-]+$/i'],
            'email'=>['required','email:rfc,dns','unique:users'],
            'password'=>['sometimes','alpha_num','min:6','max:32'],
            'confirm_password' => ['sometimes','same:password'],
            'roles' => ['sometimes','array','min:1','exists:roles,id'],
            'permissions' => [
                'sometimes',
                'array',
                'exists:permissions,id',
                new PermissionRolesCheck($this->roles),
            ],
        ];
    }

    /**
     * Reset form fields
     * 
     * @return fields reseted
     */
    public function resetInputFields()
    {
        $this->reset(
            ['name','email','password','confirm_password', 'roles', 'permissions']
        );
        $this->resetErrorBag();
        $this->form_title = "New User";
        $this->submit_btn_title = "Save";
    }

    /**
     * Livetime validation
     * 
     * @param $propertyName to validate specific field
     * 
     * @return real time validation
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules());
    }

    /**
     * Form create and update user
     * 
     * @return admin.user
     */
    public function saveForm()
    {
        $op = "";
        $myfield=[];

        if (strcmp($this->submit_btn_title, "Save")==0) {

            $this->validate($this->rules());

            if (empty($this->password)) {
                $this->password = Str::random(8);
            }

            $validatedData =[
                'name' => $this->name,
                'email' =>$this->email,
                'password' => bcrypt($this->password),
            ];


            $user = User::create($validatedData);

            $user->attachRoles($this->roles);

            if (!empty($this->permissions)) {
                $user->attachPermissions($this->permissions);
            }

            $user->contacts()->create(['type' => 'primary']);

            $user->sendEmailVerificationNotification();

            $op = "created";

        } else {

            $user = User::findOrFail($this->user_id);

            //$this->updated($this->name);
            if (strcmp($this->name, $user->name)!=0) {
                $user->name = $this->name;
                $myfield['name'] = $this->name;
            }

            if (strcmp($this->email, $user->email)!=0) {
                $myfield['email'] = $this->email;
                //$this->updated($this->email);
                $user->email = $this->email;
            }

            if (!empty($this->password)) {
                $user->password = bcrypt($this->password);
                $myfield['passord'] = 'password';
                //dd($user);
            }
            
            if (sizeof($myfield)>0) {
                $user->save();
            }

            $user->syncRoles($this->roles);
            $user->syncPermissions($this->permissions);
            $op = "updated";

            //dd($myfield);

            //User::create($validatedData);
            $user->notify(new UserUpdate($myfield));

        }

        $this->dispatchBrowserEvent('closeUserModal');
        //$this->emit('refreshUser');
        $this->emit(
            'alert', 
            [
                'type'=>'success',
                'message'=>'User '.$op.' successfully'
                ]
        );
        
        //session()->flash('success', 'User saved successfully');

        //return redirect()->to('admin/users');

    }

    /** 
     * Edit users
     * 
     * @param $id user
     * 
     * @return view|user 
     */
    public function edit($id)
    {
        $this->resetInputFields();

        $user = User::findOrFail($id);
        
        $this->form_title = "Edit User";

        $this->submit_btn_title = "Update";


        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->roles = $user->roles;
        $this->permissions = $user->permissions;
        
        $this->dispatchBrowserEvent(
            'openUserModal', 
            [
                'roles' => $this->roles,
                'permissions'=>$this->permissions,
            ]
        );
    }

}
