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

use App\Models\Apartment;
use Livewire\Component;
use App\Models\ApartmentType;
/**
 *  Extended Laratrust Roles Classe
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class ApartmentForm extends Component
{
    public $submit_btn_title = "save";
    public $apart_id;
    public $building_id;
    public $apartment_type_id;
    public $number;
    public $description;
    public $myCompany;
    public $mytypes;

    protected $listeners = [
        'editApartment' => 'edit', 
        'resetApartmentInputFiels' => 'resetInputFields'
    ];
    
    
    /**
     * Mount
     *
     * @param $company my company
     * 
     * @return void
     */
    public function mount($company)
    {
        $this->myCompany = $company;
        $this->mytypes = ApartmentType::all();
    }

    /**
     * Render
     *
     * @return Illuminate\Support\Facades\View
     */
    public function render()
    {
        //dd($this->mytypes->pluck('tag', 'id'));
        return view(
            'livewire.management.apartment-form', 
            [
                'apartbuildings' => $this->myCompany->buildings
                    ->sortBy('alias')->pluck('alias', 'id'),
                'apartypes' => $this->mytypes->pluck('full_name', 'id')
            ]
        );
    }
    
    /**
     * Rules
     *
     * @return void
     */
    protected function rules()
    {
        return [
            'building_id' => 'required|exists:buildings,id',
            'apartment_type_id' => 'required|exists:apartment_types,id',
            'number' => 'required|alpha_num',
            'description' => 'nullable|string|min:3|max:255'
        ];
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
     * SaveApartmentForm
     *
     * @return void
     */
    public function saveApartmentForm()
    {
        $msg = "Apartment created successfuly";
        $msg_type = "success";

        $validatedData = $this->validate();

        Apartment::updateOrCreate(
            ['id'=>$this->apart_id],
            $validatedData
        );
        if (strcmp($this->submit_btn_title, "save")!=0) {
            $msg = "Apartment updated successfuly";

        } 

        $this->dispatchBrowserEvent('closeApartmentModal');
        $this->emit('refreshApartments');
        $this->emit(
            'alert', 
            [
                'type'=>$msg_type,
                'message'=>$msg,
                ]
        );
    }
    
    /**
     * ResetInputFields
     *
     * @return void
     */
    public function resetInputFields()
    {
        $this->reset(
            [
                'apart_id',
                'building_id',
                'apartment_type_id',
                'number',
                'description',
            ]
        );
        $this->resetErrorBag();
        $this->submit_btn_title = "save";
    }
    
    /**
     * Edit
     * 
     * @param Apartment $apartment apart to be edited
     *
     * @return void
     */
    public function edit(Apartment $apartment)
    {
        $this->apart_id = $apartment->id;
        $this->building_id = $apartment->building_id;
        $this->apartment_type_id = $apartment->apartment_type_id;
        $this->number = $apartment->number;
        $this->description = $apartment->description;
        $this->submit_btn_title = "update";
        $this->dispatchBrowserEvent('openApartmentModal');
        
    }
}
