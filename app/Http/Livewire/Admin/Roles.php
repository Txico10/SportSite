<?php
/** 
 * Livewire Roles Component
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
use Livewire\Component;
use Livewire\WithPagination;
/**
 *  Livewire Roles component
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class Roles extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $sortField= 'display_name';
    public $sortAsc = true;
    public $search_role = '';


    protected $queryString = ['search_role'=> ['except' => '']];

    protected $listeners = ['refreshParent' => '$refresh', 
                            'deleteRole'=>'delete',
                            'infoRole' 
                           ];

    /**
     * Render the livewire users view
     * 
     * @return livewire_roles
     */
    public function render()
    {
        return view(
            'livewire.admin.roles', 
            [
                'roles' => Role::search($this->search_role)
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
     * Reset pagination on search
     * 
     * @return resetPage
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /** 
     * Info Role
     * 
     * @param $id role id
     * 
     * @return role info blade
     */
    public function infoRole($id)
    {
        $role = Role::findOrFail($id);
        
        $html = '<div class="container-fluid">
                <div class="card card-outline card-primary">
                    <div class="card-header border-0">
                    <h3 class="card-title">Showing role '.$role->display_name.'</h3>
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
                                        <td><p class="text-primary">Role ID</p></td>
                                        <td align="right">'.$role->id.'</td>
                                    </tr>
                                    <tr>
                                        <td><p class="text-primary">Role tag</p></td>
                                        <td align="right">'.$role->name.'</td>
                                    </tr>
                                    <tr>
                                <td><p class="text-primary">Role description</p></td>
                                        <td align="right">'.$role->description.'</td>
                                    </tr>
                                    <tr>
                                    <td><p class="text-primary">Permissions</p></td>
                                        <td align="right">';

        foreach ($role->permissions->chunk(3) as $permissions) {
            foreach ($permissions as $key => $permission) {
                $html = $html.'<span class="badge bg-secondary">'.
                $permission->display_name.'</span> &nbsp;';
            }
            $html = $html.'<br>';
        }
        $html = $html.'</td>
                    </tr>
                    <tr>
                        <td><p class="text-primary">Role users</p></td>
                        <td align="right">'.$role->users->count().'</td>
                    </tr>
                    <tr>
                        <td><p class="text-primary">Created at</p></td>
                        <td align="right">'.$role->created_at.'</td>
                    </tr>
                    <tr>
                        <td><p class="text-primary">Updated at</p></td>
                        <td align="right">'.$role->updated_at.'</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>';

        $html = preg_replace('/\>\s+\</m', '><', $html);

        
        $this->emit('modal-roleInfo', $html);



    }

    /**
     * Personalize pagination
     * 
     * @param $id role id
     * 
     * @return void
     */
    public function delete($id)
    {
        $role=Role::findOrFail($id);

        $users = $role->users;

        if ($users->count()>0) {
            foreach ($users as $user) {
                $user->detachRole($role);
            }
        }

        $permissions = $role->permissions;

        if ($permissions->count()>0) {
            
            $role->detachPermissions($permissions);
        }

        $role->delete();

        $this->emit(
            'alert', 
            [
                'type'=>'success',
                'message'=>'Role deleted successfully'
            ]
        );

    }
}
