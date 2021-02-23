<?php
/** 
 * Livewire Roles Form Component
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
use Livewire\Component;
/**
 *  Livewire Roles Form class component
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class RolesForm extends Component
{
    public $submit_btn_title = "Save";

    public $role_id;
    public $name;
    public $display_name;
    public $description;
    public $permissions=[];

    protected $rules = [
        'name'=>'required|string|min:3|max:32',
        'display_name'=>'sometimes|string|min:6|max:32|regex:/^[a-z ,.\'-]+$/i',
        'description'=>'sometimes|string|min:6|max:32|regex:/^[a-z ,.\'-]+$/i',
        'permissions' =>'sometimes|array|min:1|exists:permissions,id',
    ];

    protected $listeners = ['editRole'=>'edit', 
                            'resetRoleInputFields' => 'resetInputFields',
                           ];

    /**
     * Render the livewire users view
     * 
     * @return livewire_roles_form
     */
    public function render()
    {
        return view(
            'livewire.admin.roles-form', 
            [
                'permissionsList'=> Permission::all(),
            ]
        );
    }

    /**
     * Reset form fields
     * 
     * @return void
     */
    public function resetInputFields()
    {
        $this->reset(['role_id','name','display_name','description', 'permissions']);
        $this->resetErrorBag();
        $this->resetValidation();
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
     * Livetime validation
     * 
     * @return message
     */
    public function saveRoleForm()
    {
        $this->validate();
        $op="";

        if (strcmp($this->submit_btn_title, 'Save') == 0) {
            $role = [
                'name' =>$this->name,
                'display_name' => $this->display_name,
                'description' => $this->description, 
            ];
            
            $role = Role::create($role);
            if (!empty($this->permissions)) {
                //dd($this->permissions);
                $role->attachPermissions($this->permissions);
            }
            $op = "saved";

        } else {

            //dd($this->permissions);

            $role = Role::findOrFail($this->role_id);

            if (strcmp($this->name, $role->name)==0) {
                
                $role->display_name = $this->display_name;
                $role->description = $this->description;

            } else {
                $role->name = $this->name;
                $role->display_name = $this->display_name;
                $role->description = $this->description;
            }

            $role->syncPermissions($this->permissions);

            $role->update();

            $op = "updated";
        }
        
        $this->dispatchBrowserEvent('closeRoleModal');
        $this->emit('refreshParent');
        
        $this->emit(
            'alert', 
            [
                'type'=>'success',
                'message'=>'Role '.$op.' successfully',
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
    public function edit($id)
    {

        $role = Role::findOrFail($id);
        

        $this->submit_btn_title = "Update";


        $this->role_id = $role->id;
        $this->name = $role->name;
        $this->display_name = $role->display_name;
        $this->description = $role->description;
        $this->permissions = $role->permissions;

        $this->dispatchBrowserEvent(
            'openRoleModal', 
            [
                'permissions'=>$this->permissions,
            ]
        );
    }

}
