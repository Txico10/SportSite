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

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

/**
 *  Livewire Users component
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */

class Users extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $sortField= 'name';
    public $sortAsc = true;
    public $search = '';


    protected $queryString = ['search'=> ['except' => '']];

    protected $listeners = [
        'refreshUser' => '$refresh', 
        'deleteUser' => 'delete',
        'infoUser',
        'changeStatus'
    ];
        

    /**
     * Render the livewire users view
     * 
     * @return livewire_users
     */
    public function render()
    {
        return view(
            'livewire.admin.users', 
            [
              'users' => User::search($this->search)
              ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
              ->paginate($this->perPage), 
            ] 
        );
    }


    /**
     * Render the livewire users view
     * 
     * @param $field represents the field to sort
     * 
     * @return null
     */
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    /**
     * Personalize pagination
     * 
     * @return pagination-links
     */
    public function paginationView() 
    {
        return '.includes.pagination-links';
    }

    /**
     * Personalize pagination
     * 
     * @return pagination-links
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Delete user
     * 
     * @param $id user
     * 
     * @return view|users
     */
    public function delete($id)
    {
        $user = User::findOrFail($id);
        
        $roles = $user->roles;
        //dd(count($roles));
        
        if ($roles->count()>0) {
                $user->detachRoles($roles);
        }        
        
        $permissions = $user->permissions;
        if ($permissions->count()>0) {
                $user->detachPermissions($permissions);
            
        }

        $user->delete();
        
        $this->emit(
            'alert', 
            [
                'type'=>'success',
                'message'=>'User deleted successfully'
            ]
        );
    }

    /** 
     * Info Role
     * 
     * @param $id role id
     * 
     * @return role info blade
     */
    public function infoUser($id)
    {
        $user = User::findOrFail($id);
        
        $html = '<div class="container-fluid">
                <div class="card card-outline card-primary">
                    <div class="card-header border-0">
                    <h3 class="card-title">Showing '.$user->name.' info</h3>
                        <div class="card-tools">
                            <a href="#" class="btn btn-tool btn-sm">
                                <i class="fas fa-download"></i>
                            </a>
                            <a href="#" class="btn btn-tool btn-sm">
                                <i class="fas fa-bars"></i>
                            </a>
                        </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-striped table-valign-middle">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><p class="text-primary">ID</p></td>
                                        <td align="right">'.$user->id.'</td>
                                    </tr>
                                    <tr>
                                    <td><p class="text-primary">Name</p></td>
                                        <td align="right">'.$user->name.'</td>
                                    </tr>
                                    <tr>
                                    </tr>
                                    <tr>
                                    <td><p class="text-primary">Email</p></td>
                                        <td align="right">'.$user->email.'</td>
                                    </tr>
                                    <tr>
                                    <td><p class="text-primary">Roles</p></td>
                                        <td align="right">';
        foreach ($user->roles->chunk(3) as $roles) {
            foreach ($roles as $key => $role) {
                $html = $html.'<span class="badge bg-secondary">'.
                $role->display_name.'</span> &nbsp;';
            }
            $html = $html.'<br>';
        }
        
        $html = $html.'</td>
                    </tr>
                    <tr>
                        <td><p class="text-primary">Permissions</p></td>
                        <td align="right">';
        foreach ($user->permissions->chunk(3) as $permissions) {
            foreach ($permissions as $key => $permission) {
                $html = $html.'<span class="badge bg-secondary">'.
                $permission->display_name.'</span> &nbsp;';
            }
            $html = $html.'<br>';
        }
        $html=$html.'</td>
                    </tr>
                    <tr>
                        <td><p class="text-primary">Created at</p></td>
                        <td align="right">'.$user->created_at.'</td>
                    </tr>
                    <tr>
                        <td><p class="text-primary">Updated at</p></td>
                        <td align="right">'.$user->updated_at.'</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>';

        $html = preg_replace('/\>\s+\</m', '><', $html);

        
        $this->emit('triggerInfoUser', $html);



    }

    /** 
     * Info Role
     * 
     * @param $id role id
     * 
     * @return role info blade
     */
    public function changeStatus($id)
    {
        $op ="";
        $user = User::findOrFail($id);
        if ($user->status) {
            $user->status = 0;
            $op = "disabled";
        } else {
            $user->status =1;
            $op = "enabled";
        }

        $user->save();
        
        $this->emit(
            'alert', 
            [
                'type'=>'success',
                'message'=>'User status '.$op.' successfully'
            ]
        );
    }

}
