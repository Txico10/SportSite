<?php
/** 
 * Laravel Users
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

use App\Models\RealState;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;
/**
 *  Profile class
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class CompanyForm extends Component
{
    use WithFileUploads;
    public $myCompany;
    public $company_id;
    public $logo;
    public $old_logo;
    public $name;
    public $old_name;
    public $neq;
    public $legalform;
    public $old_legalform;

    protected $listeners = [
        'editCompany'=>'edit',
        'resetCompanyInputFields' => 'resetInputFields'
    ];

    /**
     * Mount profile form
     * 
     * @param $company company info
     * 
     * @return profile form
     */
    public function mount(RealState $company)
    {
        $this->myCompany = $company;
        $this->company_id = $company->id;
        $this->logo = $company->logo;
        $this->old_logo = $company->logo;
        $this->name = $company->name;
        $this->old_name = $company->name;
        $this->neq = $company->neq;
        $this->legalform = $company->legalform;
        $this->old_legalform = $company->legalform;
    }

    /**
     * Render the livewire contact view
     * 
     * @return user_contact
     */
    public function render()
    {
        return view('livewire.management.company-form');
    }

    /**
     * Save form
     * 
     * @return user_contact
     */
    public function saveForm()
    {
        $company = $this->myCompany;
        $myRules = array();
        if ($this->old_logo !== $this->logo) {
            $myRules['logo'] = 'image|max:1024'; // 1MB Max;
            if (strcmp($this->old_logo, "defaultCompany.png")!= 0) {
                Storage::delete('public/profile_images/companies/'.$this->old_logo);
            }
            $filename = Str::random().time().'.'.$this->logo->extension();
            $this->logo->storeAs('public/profile_images/companies/', $filename);

            $company->logo=$filename;

            $path = public_path('storage/profile_images/companies/'.$filename);
            $width = 128;
            $height = 128;
            $img = Image::make($path)->resize(
                $width, $height, 
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            );
            $img->save($path);

        }
        if ($this->old_name !== $this->name) {
            $myRules['name'] = 'required|string|min:3|max:191';
            $company->name = $this->name;
        }
        if ($this->old_legalform !== $this->legalform) {
            $myRules['legalform'] = array(
                'required', 
                Rule::in(
                    [
                        'Sole proprietorship', 
                        'Business corporation', 
                        'General partnership', 
                        'Limited partnership', 
                        'Cooperative'
                    ]
                )
            );
            $company->legalform = $this->legalform;
        }

        if (!empty($myRules)) {
            $companyData = $this->validate($myRules);
            
            $company->save();
            $type = 'success';
            $message = 'Updated successfully';
            
        } else {
            $type = 'warning';
            $message = 'Not Updates';
        }
        $this->dispatchBrowserEvent('closeCompanyModal');
        $this->emit('refreshCompany');
        $this->emit(
            'alert', 
            [
                'type'=>$type,
                'message'=>$message
            ]
        );
    }


    /**
     * Fields Validation
     * 
     * @param $propertyName fiels name
     * 
     * @return validate 
     */
    public function updated($propertyName)
    {
        $this->validateOnly(
            $propertyName, 
            [
                'name'=>'required|string|min:3|max:191',
                'legalform'=>
                [
                    'required', Rule::in(
                        [
                            'Sole proprietorship', 
                            'Business corporation', 
                            'General partnership', 
                            'Limited partnership', 
                            'Cooperative'
                        ]
                    )
                ],
                'logo' => 'image|max:1024', // 1MB Max
            ]
        );
    }

    /**
     * Reset form fields
     * 
     * @return void
     */
    public function resetInputFields()
    {
        $this->reset(
            [
                'name',
                'old_name', 
                'neq' ,
                'legalform',
                'old_legalform',
                'logo', 
                'old_logo'
            ]
        );
        $this->resetErrorBag();
    }

    /**
     * Edit company informations
     * 
     * @param $id Company ID
     * 
     * @return RealState 
     */
    public function edit($id)
    {
        $company = $this->myCompany;
        $this->logo = $company->logo;
        $this->old_logo = $company->logo;
        $this->name = $company->name;
        $this->old_name = $company->name;
        $this->neq = $company->neq;
        $this->legalform = $company->legalform;
        $this->old_legalform = $company->legalform;
        $this->dispatchBrowserEvent('openCompanyModal');
    }
}
