<?php
/** 
 * Livewire Permission Form Component
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
use Livewire\Component;
/**
 *  Livewire permission Form class component
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class PermissionsForm extends Component
{
    public $submit_btn_title = "Save";

    public $permission_id;
    public $name;
    public $display_name;
    public $description;

    protected $rules = [
        'name'=>'required|string|min:3|max:32|unique:permissions',
        'display_name'=>'sometimes|string|min:6|max:32|regex:/^[a-z ,.\'-]+$/i',
        'description'=>'sometimes|string|min:6|max:32|regex:/^[a-z ,.\'-]+$/i',
    ];

    protected $listeners = ['editPermission'=>'edit', 
                            'resetPermissionsInputFields'=>'resetInputFields'];


    /**
     * Render the livewire users view
     * 
     * @return livewire_roles_form
     */
    public function render()
    {
        return view('livewire.admin.permissions-form');
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
     * Reset form fields
     * 
     * @return void
     */
    public function resetInputFields()
    {
        $this->reset(['permission_id','name','display_name','description']);
        $this->resetErrorBag();
        $this->resetValidation();
        $this->submit_btn_title = "Save";
    }

    /**
     * Livetime validation
     * 
     * @return message
     */
    public function savePermissionForm()
    {
        $op = "";

        if (strcmp($this->submit_btn_title, 'Save') == 0) {
            $validatedData = $this->validate();
            Permission::create($validatedData);
            $op = "created";

        } else {

            $permission = Permission::findOrFail($this->permission_id);

            if (strcmp($this->name, $permission->name)==0) {
                
                $permission->display_name = $this->display_name;
                $permission->description = $this->description;

            } else {
                $permission->name = $this->name;
                $permission->display_name = $this->display_name;
                $permission->description = $this->description;
            }
            $permission->update();
            $op = "updated";
        }
        
        $this->emit('refreshParent');
        $this->dispatchBrowserEvent('closePermissionModal');        
        
        $this->emit(
            'alert', 
            ['type'=>'success',
             'message'=>'Permission '.$op.' successfully']
        );
    }
    
    /**
     * Render the livewire users view
     * 
     * @param $id permissions id
     * 
     * @return livewire_permissions_form
     */
    public function edit($id) 
    {
        $permission = Permission::findOrFail($id);
        
        $this->submit_btn_title = "Update";

        $this->permission_id = $permission->id;
        $this->name = $permission->name;
        $this->display_name = $permission->display_name;
        $this->description = $permission->description;

        $this->dispatchBrowserEvent('openPermissionModal');
    }
}
