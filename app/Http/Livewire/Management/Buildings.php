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


use Illuminate\Pagination\LengthAwarePaginator;
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
    public $myCompany;

    protected $listeners = [
        'refreshBuildings' => '$refresh', 
    ];

    /**
     * Render the livewire users view
     * 
     * @param $company represents the field to sort
     * 
     * @return null
     */
    public function mount($company)
    {
        $this->myCompany = $company;
    }

    /**
     * Livewire render
     * 
     * @return view
     */
    public function render()
    {
        //dd($this->sortAsc);
        if (empty($this->search)) {

            $buildings = $this->myCompany->buildings;

        } else {

            $buildings = $this->myCompany->buildings
                ->filter(
                    function ($value, $key) {
                        return false !== stristr($value->lot, $this->search) || 
                            false !== stristr($value->alias, $this->search) || 
                            false !== stristr($value->description, $this->search);
                    }
                );
        }

        if ($this->sortAsc) {
            $newBuildings = $buildings->sortBy(
                function ($building, $key) {
                    return str_replace(' ', '', $building[$this->sortField]);
                }
            );
        } else {
            $newBuildings = $buildings->sortByDesc(
                function ($building, $key) {
                    return str_replace(' ', '', $building[$this->sortField]);
                }
            );
        }
        
        $items = $newBuildings->forPage($this->page, $this->perPage);
        
        $paginator = new LengthAwarePaginator(
            $items, 
            $newBuildings->count(), 
            $this->perPage, 
            $this->page
        );
        
        return view(
            'livewire.management.buildings',
            [
                'buildings' => $paginator,
                'company' => $this->myCompany
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
