<?php
/** 
 * Building Component
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

use App\Models\Building;
use Livewire\Component;
use Livewire\WithPagination;
/**
 *  Extended Livewire component
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class Buildings extends Component
{
    use WithPagination;

    public $search ='';
    public $sortField = 'lot';
    public $perPage = 10;
    public $sortAsc = true;
    public $company_id;

    /**
     * Render the livewire users view
     * 
     * @param $company represents the field to sort
     * 
     * @return null
     */
    public function mount($company)
    {
        $this->company_id = $company;
    }

    /**
     * Livewire render
     * 
     * @return view
     */
    public function render()
    {
        return view(
            'livewire.management.buildings',
            [
                'buildings' => Building::search($this->search)
                    ->ofCompany($this->company_id)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage),
            ]
        );
    }

    /**
     * Pagination View
     * 
     * @return null
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
