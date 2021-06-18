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

use App\Models\FurnitureType;
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
    public $submit_btn_title = "Save";
    public $manufacturer;
    public $model;
    public $serial;
    public $buy_at;
    public $salvage_at;
    public $qrcode;
    public $furnitureList;
    public $furniture_type_id;
    public $company;
        
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

        //dd($this->company);
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
     * SaveFurnitureForm
     *
     * @return void
     */
    public function saveFurnitureForm()
    {
        dd("Save Furniture Form");
    }
}
