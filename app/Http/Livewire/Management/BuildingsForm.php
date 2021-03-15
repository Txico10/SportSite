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
    public $company;
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
    
    //protected $rules = [
    //    'alias' => 'required|string|min:3',
    //    'description' => 'nullable|string|min:3|max:255'
    //];

    //protected $messages = [
    //    'lot.exists' => 'The lot can\'t be updated'
    //];
        
    /**
     * Mount
     *
     * @param mixed $company my company
     * 
     * @return void
     */
    function mount($company)
    {
        $this->company = $company;
    }

    /**
     * Render
     *
     * @return view building-form
     */
    public function render()
    {
        //dd($this->building_id);
        return view('livewire.management.buildings-form');
    }
    
    /**
     * Rules
     *
     * @return void
     */
    protected function rules()
    {

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
        //dd($building);
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
        $msg = "";
        //$this->updatedLot();
        $validatedData = $this->validate();

        if (strcmp($this->submit_btn_title, "save")==0) {
            
            //$validatedData['lot'] = $this->lot;
            $newBuilding = $this->company->buildings()->create($validatedData);
            $newBuilding->contact()->create(['type' => 'primary']);
            $msg = "created";
            //dd($validatedData);
        } else {
            //$this->validate(['lot' => 'required|string|exists:buildings,lot']);
            //$validatedData = $this->validate();
            //$validatedData['lot'] = $this->lot;
            //$validatedData['id'] = $this->building_id;
            $newBuilding = $this->company->buildings
                ->firstWhere('id', $this->building_id);

            if (isset($validatedData['lot']) && strcmp($validatedData['lot'], $newBuilding->lot)!=0) {
                $newBuilding->lot = $validatedData['lot'];
            }

            if (strcmp($validatedData['alias'], $newBuilding->alias)!=0) {
                $newBuilding->alias = $validatedData['alias'];
            }

            if (isset($validatedData['description']) && strcmp($validatedData['description'], $newBuilding->description)!=0) {
                $newBuilding->description = $validatedData['description'];
            }
            //dd($validatedData);
            $newBuilding->save();
            $msg = "updated";
            
        }
        
        $this->dispatchBrowserEvent('closeBuildingModal');
        $this->emit('refreshBuildings');
        //$this->emit('refreshApartments');
        $this->emit(
            'alert', 
            [
                'type'=>'success',
                'message'=>'Building '.$msg.' successfully'
                ]
        );
        //dd($validatedData);
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
