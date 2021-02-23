<?php
/** 
 * Laratrust Roles Component
 * 
 * PHP version 7.4
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
namespace App\Http\Livewire\Management;

use App\Models\Employee;
use Livewire\Component;
use Livewire\WithPagination;
/**
 *  Extended Laratrust Roles Classe
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class Employees extends Component
{
    use WithPagination;

    public $company_id;
    public $search ='';
    public $sortField = 'name';
    public $perPage = 10;
    public $sortAsc = true;

    /**
     * Mount the livewire users view
     * 
     * @param $companyId company_id
     * 
     * @return page
     */
    public function mount($companyId)
    {
        $this->company_id = $companyId;
    }

    /**
     * Render the livewire users view
     * 
     * @return page
     */
    public function render()
    {
        return view(
            'livewire.management.employees',
            [
                'employees' => Employee::search($this->search)
                    ->ofCompany($this->company_id)
                    ->ofUserRole()
                    ->ofRole()
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage),
            ]
        );
    }

    /**
     * Render the livewire users view
     * 
     * @return page
     */
    public function paginationView() 
    {
        return '.includes.pagination-links';
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
}
