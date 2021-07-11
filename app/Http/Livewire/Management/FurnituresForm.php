<?php
/** 
 * Furniture Form Livewire Controller
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

use App\Models\Furniture;
use App\Models\FurnitureType;
use Carbon\Carbon;
use Livewire\Component;
/**
 *  Furniture Form Livewire component
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class FurnituresForm extends Component
{
    public $submit_btn_title = "save";
    public $manufacturer;
    public $model;
    public $serial;
    public $buy_at;
    public $salvage_at;
    public $qrcode;
    public $furnitureList;
    public $furniture_type_id;
    public $furniture_id;
    public $real_state_id;
    public $company;
    
    protected $listeners = [
        'editFurniture' => 'edit', 
        'resetFurnitureInputFields' => 'resetInputFields'
    ];

    /**
     * Mount
     * 
     * @param $company Furnitures
     *
     * @return void
     */
    public function mount($company)
    {
        $this->furnitureList = FurnitureType::all()->pluck('description', 'id');
        $this->company = $company;
        $this->real_state_id = $company->id;
    }

    /**
     * Render
     *
     * @return void
     */
    public function render()
    {
        return view(
            'livewire.management.furnitures-form', 
            [
                'furnitureList' => $this->furnitureList,
                'company' => $this->company,
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
            'real_state_id' => 'required|exists:real_states,id',
            'furniture_type_id' => 'required|exists:furniture_types,id',
            'manufacturer' => 'required|string|min:3|max:255',
            'model' => 'required|alpha_num',
            'serial' => 'required|alpha_num',
            'buy_at' => 'date|before_or_equal:today',
            'salvage_at' => 'nullable|date|after:startDate',
            'qrcode' => 'nullable|image|dimensions:max_width=165,max_height=165',
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
     * Save Furniture Form
     *
     * @return void
     */
    public function saveFurnitureForm()
    {
        $msg_type = "success";
        $msg = "Furniture created successfuly";

        $validatedData = $this->validate();

        Furniture::updateOrCreate(
            ['id' => $this->furniture_id],
            $validatedData
        );
        
        if (strcmp($this->submit_btn_title, "save")!=0) {
            $msg = "Furniture updated successfuly";
        }

        $this->dispatchBrowserEvent('closeFurnitureModal');
        session()->flash('status', $msg);
        return redirect()->route('company.furnitures', ['id'=>$this->real_state_id]);
    }
    
    /**
     * Edit
     *
     * @param $furniture furniture id
     * 
     * @return void
     */
    public function edit(Furniture $furniture)
    {
        //$furniture = $this->company->furnitures->where('id', $id)->first();
        
        $this->furniture_id = $furniture->id;
        $this->furniture_type_id = $furniture->furniture_type_id;
        $this->manufacturer = $furniture->manufacturer;
        $this->model = $furniture->model;
        $this->serial = $furniture->serial;
        $this->buy_at = $furniture->buy_at;
        $this->salvage_at = $furniture->salvage_at;
        $this->qrcode = $furniture->qrcode;
        $this->submit_btn_title = "update";
        $formatedDate = Carbon::parse($this->buy_at)->format('d-m-Y');
        $this->dispatchBrowserEvent(
            'openFurnitureModal', 
            [
                'buy_at' => $formatedDate
            ]
        );
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
                'manufacturer',
                'model',
                'serial',
                'buy_at',
                'salvage_at',
                'qrcode',
                'furniture_type_id',
                'furniture_id'
            ]
        );
        $this->submit_btn_title = "save";
        $this->resetErrorBag();
    }
}
