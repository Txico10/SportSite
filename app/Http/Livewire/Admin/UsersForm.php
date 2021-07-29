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

use App\Models\Role;
use App\Notifications\UserUpdate;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

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
    public $role;

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

        $this->role = Role::where('name', 'superadministrator')->first();
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
            //'role' => ['required', 'exists:roles,id'],
            //'permissions' => [
            //    'sometimes',
            //    'array',
            //    'exists:permissions,id',
            //    new PermissionRolesCheck($this->role),
            //],
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
            [
                'name','email','password','confirm_password',
            ]
        );
        $this->resetErrorBag();
        //$this->form_title = "New User";
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
        $this->validateOnly($propertyName);
    }

    /**
     * Form create and update user
     *
     * @return admin.user
     */
    public function saveUserForm()
    {
        $this->validate();

        //dd($this->role);

        DB::beginTransaction();
        try {
            $user = User::create(
                [
                    'name'=> $this->name,
                    'email'=>$this->email,
                    'password'=>bcrypt($this->password),
                    'status' => User::ACTIVE,

                ]
            );

            if (empty($user->contact)) {
                $user->contact()->create(['type' => 'primary']);
            }

            if ($user->roles->count()==0) {
                $user->attachRole($this->role);
            }

            DB::commit();

            event(new Registered($user));

            $msgType = "success";
            $msg = "User created successfully";
        } catch (\Throwable $ex) {
            DB::rollBack();
            $msgType = "error";
            $msg = $ex->getMessage();
        }


        $this->dispatchBrowserEvent('closeUserModal');
        $this->emit(
            'newUserSpeciaCreate',
            [
                'type'=>$msgType,
                'message'=>$msg,
            ]
        );
    }

    /**
     * Edit users
     *
     * @param $id user
     *
     * @return view|user
     */
    /*
    public function edit($id)
    {
        $this->resetInputFields();

        $user = User::findOrFail($id);

        $this->form_title = "Edit User";

        $this->submit_btn_title = "Update";


        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        //$this->permissions = $user->permissions;

        $this->dispatchBrowserEvent(
            'openUserModal',
            [
                'roles' => $this->role,
                //'permissions'=>$this->permissions,
            ]
        );
    }
    */

}
