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

use App\Models\Apartment as ModelsApartment;
use App\Models\Building;
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
class Apartment extends Component
{
    use WithPagination;

    public $search ='';
    public $sortField = 'number';
    public $perPage = 10;
    public $sortAsc = true;
    public $myBuildings;
    public $building_id;

    /**
     * Initialization function
     * 
     * @param $company the company id
     * 
     * @return null
     */
    public function mount($company)
    {
        $this->myBuildings = Building::where('real_state_id', '=', $company)
            ->orderByRaw('lot', 'ASC')->get();
        if ($this->myBuildings->count()>0) {
            $this->building_id = $this->myBuildings->first()->id;
        }
            
    }

    /**
     * Reder the apartment view
     * 
     * @return view
     */
    public function render()
    {
        return view(
            'livewire.management.apartment',
            [
                'apartments' => ModelsApartment::search($this->search)
                    ->OfBuilding($this->building_id)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage),
                'myBuildings' => $this->myBuildings,
            ]
        );
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
     * Include the pagination view
     * 
     * @return pagination view
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
