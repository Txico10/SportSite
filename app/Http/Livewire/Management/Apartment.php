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


use Illuminate\Pagination\LengthAwarePaginator;
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
    public $buildingId;
    public $active_building;

    /**
     * Initialization function
     * 
     * @param $buildings the company id
     * 
     * @return null
     */
    public function mount($buildings)
    {
        $this->myBuildings = $buildings->sortBy('lot')->load('apartments');
            
    }

    /**
     * Reder the apartment view
     * 
     * @return view
     */
    public function render()
    {
        //dd($this->active_building);
        //$newBuilding = $this->myBuildings->where('id', $this->buildingId);
        if ($this->myBuildings->count()>0) {
            
            if (empty($this->active_building)) {
                $this->active_building = $this->myBuildings->first();
            }

            if (empty($this->buildingId)) {
                $this->buildingId = $this->active_building->id;
                //dump($this->buildingId);
            }
            
            if (empty($this->search)) {
            
                //dd($newBuilding[0]->apartments);
                $apartments = $this->active_building->apartments;
            } else {
                $apartments = $this->active_building->apartments
                    ->filter(
                        function ($value, $key) {
                            return false !== stristr($value->number, $this->search);
                        }
                    );
            }
    
            if ($this->sortAsc) {
                $newApartment = $apartments->sortBy(
                    function ($apartment, $key) {
                        return str_replace(' ', '', $apartment[$this->sortField]);
                    }
                );
            } else {
                $newApartment = $apartments->sortByDesc(
                    function ($apartment, $key) {
                        return str_replace(' ', '', $apartment[$this->sortField]);
                    }
                );
            }
            
            $items = $newApartment->forPage($this->page, $this->perPage);
            
            $paginator = new LengthAwarePaginator(
                $items, 
                $newApartment->count(), 
                $this->perPage, 
                $this->page
            );

        } else {
            $paginator = null;
        }
        
        return view(
            'livewire.management.apartment',
            [
                'apartments' => $paginator,
                'myBuildings' => $this->myBuildings->pluck('lot', 'id'),
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
     * UpdatingBuilding_id
     *
     * @return void
     */
    public function updatedBuildingId()
    {
        $this->active_building = $this->myBuildings
            ->where('id', $this->buildingId)
            ->first();
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
