<?php
/** 
 * Furniture Assignement Form on Livewire Controller
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

use App\Models\Apartment;
use App\Models\RealState;
use App\Rules\FurnitureAssignDate;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
/**
 *  Furniture Assignement Form on Livewire component
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class FurnituresApartmentForm extends Component
{
    public $company;
    public $furniture;
    public $buildings;
    public $apartments=[];
    public $building_id;
    public $apartment_id;
    public $assigned_at;
    
    protected $listeners = [
        'resetFurnitureAssignementInputFields' => 'resetInputFields',
        'deleteFurnitureAssign'=>'delete',
    ];

    /**
     * Mount furniture apartment form
     *
     * @param mixed $company_id Company ID
     * @param mixed $furniture  Furniture
     * 
     * @return void
     */
    public function mount($company_id, $furniture)
    {
        $this->company = RealState::findOrFail($company_id);
        $this->buildings = $this->company->buildings;
        $this->furniture = $furniture;
        
    }
        
    /**
     * Render furniture apartment form
     *
     * @return Illuminate\Support\Facades\View
     */
    public function render()
    {
        //dd($this->furniture->furnitureUnassigned());
        return view(
            'livewire.management.furnitures-apartment-form',
            [
                'buildings'=>$this->buildings,
            ]
        );
    }
        
    /**
     * Updated Building Id
     *
     * @return void
     */
    public function updatedBuildingId()
    {
        $this->apartments = Apartment::where('building_id', $this->building_id)->get();
    }
    
    /**
     * Reset Input Fields
     *
     * @return void
     */
    public function resetInputFields()
    {
        $this->reset(
            [
                'apartments',
                'building_id',
                'apartment_id',
                'assigned_at'
            ]
        );
        $this->resetErrorBag();
    }

    /**
     * Live validation
     *
     * @param mixed $propertyName validation field
     * 
     * @return void
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    
    /**
     * Validation rules
     *
     * @return array
     */
    public function rules()
    {

        return [
            'apartment_id' => ['required', 'exists:apartments,id'],
            'assigned_at' => [
                'required', 'date',  
                new FurnitureAssignDate($this->furniture->furnitureUnassigned()),
            ],
        ];
    }

    /**
     * Save Assignement Form
     *
     * @return void
     */
    public function saveAssignForm()
    {
        
        $data = $this->validate();
        
        $this->furniture->apartments()->attach($data['apartment_id'], ['assigned_at'=>$data['assigned_at']]);
        
        $this->dispatchBrowserEvent('closeFurnitureAssignementModal');
        
        session()->flash('status', 'Furniture assined successfully.');
        
        return redirect()->route('company.furnitures.show', ['id'=>$this->company->id, 'furniture'=>$this->furniture]);

    }
    
    /**
     * Delete
     *
     * @param mixed $id ID
     * 
     * @return void
     */
    public function delete($id)
    {
        DB::table('furniture_apartment')->where('id', $id)->delete();
        
        session()->flash('status', 'Furniture assinement deleted successfully.');
        
        return redirect()->route('company.furnitures.show', ['id'=>$this->company->id, 'furniture'=>$this->furniture]);

    }
}
