<?php
/** 
 * Furniture Livewire Controller
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
 *  Furniture Livewire component
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class Furnitures extends Component
{
    use WithPagination;

    public $companyFurnitures;
    public $myFurnitures;
    public $search ='';
    public $sortField = 'code';
    public $perPage = 10;
    public $sortAsc = true;
    public $furnitureType;

    protected $listeners = [
        'refreshFurnitures' => '$refresh', 
    ];
        
    /**
     * Mount
     *
     * @param mixed $company Company
     * 
     * @return void
     */
    public function mount($company)
    {
        $this->companyFurnitures = $company->load('furnitures', 'furnitures.furnitureType');
        //dd($this->companyFurnitures);
    }    
    /**
     * Render
     *
     * @return void
     */
    public function render()
    {
        $this->myFurnitures = $this->companyFurnitures->furnitures->map( 
            function ($furniture) {
                $furniture['code'] = $furniture['id'].$furniture['furniture_type_id'].$furniture['real_state_id'];
                return $furniture;
            }
        );

        if (empty($this->search)) {

            $furnitures = $this->myFurnitures;

        } else {

            $furnitures = $this->myFurnitures
                ->filter(
                    function ($value, $key) {
                        return false !== stristr($value->manufacturer, $this->search) || 
                            false !== stristr($value->model, $this->search) || 
                            false !== stristr($value->serial, $this->search) ||
                            false !== stristr($value->buy_at, $this->search) ||
                            false !== stristr($value->salvage_at, $this->search) ||
                            false !== stristr($value->furnitureType->description, $this->search) ||
                            false !== stristr($value->code, $this->search);
                    }
                );
        }

        if ($this->sortAsc) {
            $newFurnitures = $furnitures->sortBy(
                function ($furniture, $key) {
                    if ($this->sortField==="type") {
                        return str_replace(' ', '', $furniture->furnitureType["description"]);
                    } else {
                        return str_replace(' ', '', $furniture[$this->sortField]);
                    }
                }
            );
        } else {
            $newFurnitures = $furnitures->sortByDesc(
                function ($furniture, $key) {
                    if ($this->sortField==="type") {
                        return str_replace(' ', '', $furniture->furnitureType["description"]);
                    } else {
                        return str_replace(' ', '', $furniture[$this->sortField]);
                    }
                    
                }
            );
        }
        
        $items = $newFurnitures->forPage($this->page, $this->perPage);
        
        $paginator = new LengthAwarePaginator(
            $items, 
            $newFurnitures->count(), 
            $this->perPage, 
            $this->page
        );
        
        return view(
            'livewire.management.furnitures', 
            [
                'furnitures' => $paginator,
                'company' => $this->companyFurnitures,
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
