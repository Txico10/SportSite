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

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;

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
    public $myCompany;
    public $buildingId;
    public $active_building;

    protected $listeners = [
        'refreshApartments' => '$refresh', 
    ];

    /**
     * Initialization function
     * 
     * @param $company the company id
     * 
     * @return null
     */
    public function mount($company)
    {
        $this->myCompany = $company->load('buildings', 'apartments.building', 'apartments.apartmentType');
        $this->buildingId = -1;
        //dd($this->myCompany);
            
    }

    /**
     * Reder the apartment view
     * 
     * @return Illuminate\Support\Facades\View
     */
    public function render()
    {
        //dd($this->myCompany);
        //$newBuilding = $this->myBuildings->where('id', $this->buildingId);
        if ($this->myCompany->buildings->count()>0) {
            
            if (empty($this->search)) {
                if ($this->buildingId ==-1) {
                    $apartments =$this->myCompany->apartments;
                } else {
                    $apartments = $this->active_building->apartments;
                }
                //dd($newBuilding[0]->apartments);
                
            } else {
                if ($this->buildingId ==-1) {
                    $apartments = $this->myCompany->apartments
                        ->filter(
                            function ($value, $key) {
                                return false !== stristr($value->number, $this->search);
                            }
                        );
                } else {
                    $apartments = $this->active_building->apartments
                        ->filter(
                            function ($value, $key) {
                                return false !== stristr($value->number, $this->search);
                            }
                        );
                }
                
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
                'company' => $this->myCompany,
                'myBuildings' => $this->myCompany->buildings->sortBy('alias')->pluck('alias', 'id'),
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
        if ($this->buildingId > -1) {
            $this->active_building = $this->myCompany->buildings
                ->where('id', $this->buildingId)
                ->first();
        }
        
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
