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
    public $apart_building;
    public $apart_type;
    public $apart_number;
    public $apart_description;
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
     * @return view
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
            'apart_building' => 'required|exists:buildings,id',
            'apart_type' => 'required|exists:apartment_types,id',
            'apart_number' => 'required|alpha_num',
            'apart_description' => 'nullable|string|min:3|max:255'
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
        $msg = "An error occured";
        $msg_type = "error";
        $flag = false;
        $this->validate();

        if (strcmp($this->submit_btn_title, "save")==0) {
            $validatedData = [
                'building_id' => $this->apart_building,
                'apartment_type_id' => $this->apart_type,
                'number' => $this->apart_number,
            ];

            if (!empty($this->apart_description)) {
                $validatedData['description'] = $this->apart_description;
            }
            
            $this->myCompany->apartments()->create($validatedData);
            
            $msg = "created successfuly";
            $msg_type = "success";

        } else {
            if (!empty($this->apart_id)) {
                $myApartment = $this->myCompany->apartments->where('id', $this->apart_id)->first();

                if ($myApartment->building_id != $this->apart_building) {
                    $myApartment->building_id = $this->apart_building;
                    $flag = true;
                }

                if ($myApartment->apartment_type_id != $this->apart_type) {
                    $myApartment->apartment_type_id = $this->apart_type;
                    $flag = true;
                }

                if (strcmp($myApartment->number, $this->apart_number)!=0) {
                    $myApartment->number = $this->apart_number;
                    $flag = true;
                }
                
                if (strcmp($myApartment->description, $this->apart_description)!=0) {
                    $myApartment->number = $this->apart_number;
                    $flag = true;
                }

                if ($flag) {
                    $myApartment->save();
                    $msg_type = "success";
                    $msg = "updated successfully";
                } else {
                    $msg = "not updated";
                    $msg_type = "warning";
                }
            }
        }
        $this->dispatchBrowserEvent('closeApartmentModal');
        $this->emit('refreshApartments');
        $this->emit(
            'alert', 
            [
                'type'=>$msg_type,
                'message'=>'Apartment '.$msg,
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
                'apart_building',
                'apart_type',
                'apart_number',
                'apart_description',
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
        $this->apart_building = $apartment->building_id;
        $this->apart_type = $apartment->apartment_type_id;
        $this->apart_number = $apartment->number;
        $this->apart_description = $apartment->description;
        $this->submit_btn_title = "update";
        $this->dispatchBrowserEvent('openApartmentModal');
        
    }
}
