<?php
/** 
 * Livewire Clients Component
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

use App\Http\Traits\WithSorting;
use App\Models\RealState;
use Livewire\Component;
use Livewire\WithPagination;
/**
 *  Livewire clients component
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class Clients extends Component
{
    use WithPagination;
    use WithSorting;

    protected $listeners = ['refreshClient'=>'$refresh'];
    /**
     * Render the livewire users view
     * 
     * @return livewire_Clients
     */
    public function render()
    {
        return view(
            'livewire.admin.clients', 
            [
                'clients' => RealState::search($this->search)
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage), 
            ]
        );
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
}
