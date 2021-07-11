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
/**
 *  Livewire building form component
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class BuildingsForm extends Component
{
    public $building_id;
    public $real_state_id;
    public $lot;
    public $old_lot;
    public $alias;
    public $description;
    public $submit_btn_title = "save";

    protected $listeners = [
        'editBuilding' => 'edit', 
        'editBuildingContact' => 'editContact',
        'resetBuildingInputFields' => 'resetInputFields'
    ];
        
    /**
     * Mount
     *
     * @param mixed $company my company
     * 
     * @return void
     */
    function mount($company)
    {
        $this->real_state_id = $company->id;
    }

    /**
     * Render
     *
     * @return Illuminate\Support\Facades\View
     */
    public function render()
    {
        return view('livewire.management.buildings-form');
    }
    
    /**
     * Rules
     *
     * @return void
     */
    protected function rules()
    {
        if (empty($this->building_id)) {
            $myRule['real_state_id'] = 'required|exists:real_states,id';
        }

        if (empty($this->building_id) || strcmp($this->lot, $this->old_lot) !=0) {
            $myRule['lot'] = 'required|string|unique:buildings';
        }

        $myRule['alias'] = 'required|string|min:3';
        $myRule['description'] = 'nullable|string|min:3|max:255';

        return $myRule;
    }
        
    /**
     * Updated
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
     * Edit
     * 
     * @param $building building to be edited
     * 
     * @return void
     */
    public function edit($building)
    {
        $this->building_id = $building['id'];
        $this->lot = $building['lot'];
        $this->old_lot = $building['lot'];
        $this->alias = $building['alias'];
        $this->description = $building['description'];
        $this->submit_btn_title = 'update';
        $this->dispatchBrowserEvent('openBuildingModal', ['lot' => $this->lot]);
    }
    
    /**
     * SaveBuildingForm to save and update building
     *
     * @return void
     */
    public function saveBuildingForm()
    {
        $msg = "Building created successfully";
        
        $validatedData = $this->validate();

        $newBuilding = Building::updateOrCreate(
            ['id' => $this->building_id],
            $validatedData
        );

        if (strcmp($this->submit_btn_title, "save")==0) {
            $newBuilding->contact()->create(['type' => 'primary']);
        } else {
            $msg = "Building updated successfully";
        }
        
        $this->dispatchBrowserEvent('closeBuildingModal');
        $this->emit('refreshBuildings');
        //$this->emit('refreshApartments');
        $this->emit(
            'alert', 
            [
                'type'=>'success',
                'message'=>$msg,
                ]
        );
    }
    
    /**
     * ResetInputFields reset input fields
     *
     * @return void
     */
    public function resetInputFields()
    {
        $this->reset(
            [
                'building_id',
                'lot',
                'old_lot',
                'alias',
                'description',
            ]
        );
        $this->resetErrorBag();
        $this->submit_btn_title = "save";
    }

}
