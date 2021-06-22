<?php
/** 
 * Company contact form
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

use App\Models\Contact;
use Illuminate\Validation\Rule;
use Livewire\Component;
use PragmaRX\Countries\Package\Countries;
/**
 *  Company contact form class
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class ContactForm extends Component
{
    public $submit_btn_title = "update";
    public $oldContact;
    public $contact_id;
    public $suite;
    public $num;
    public $street;
    public $city;
    public $region;
    public $country;
    public $pc;
    public $telephone;
    public $mobile;
    public $email;
    public $allCountries;
    public $countryCities;

    protected $listeners = [
        'editContact'=> 'edit', 
        'resetContactInputFiels' => 'resetInputFields',
    ];
    
    /**
     * Mount
     *
     * @return void
     */
    public function mount()
    {
        $this->allCountries = Countries::all()->pluck('name.common', 'cca3')->toArray();
    }
    /**
     * Display a listing of the resource.
     *
     * @return view
     */
    public function render()
    {
        return view(
            'livewire.management.contact-form', 
            [
                'allCountries'=>$this->allCountries,
            ]
        );
    }

    /**
     * Save contact form.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveContactForm()
    {
        $this->validate();

        $op = '';
        $type = '';

        $contact = $this->oldContact;

        if (strcmp($contact->suite, $this->suite)!=0) {
            $contact->suite = $this->suite;
        }
        if (strcmp($contact->num, $this->num)!=0) {
            $contact->num = $this->num;
        }
        if (strcmp($contact->street, $this->street)!=0) {
            $contact->street = $this->street;
        }
        if (strcmp($contact->city, $this->city)!=0) {
            $contact->city = $this->city;
        }
        if (strcmp($contact->region, $this->region)!=0) {
            $contact->region = $this->region;
        }
        if (strcmp($contact->country, $this->country)!=0) {
            $contact->country = $this->country;
        }
        if (strcmp($contact->pc, $this->pc)!=0) {
            $contact->pc = $this->pc;
        }
        if (strcmp($contact->telephone, $this->telephone)!=0) {
            $contact->telephone = $this->telephone;
        }
        if (strcmp($contact->mobile, $this->mobile)!=0) {
            $contact->mobile = $this->mobile;
        }
        if (strcmp($contact->email, $this->email)!=0) {
            $contact->email = $this->email;
        }

        if ($contact->isDirty()) {
            $contact->save();
            $type = 'success';
            $op = "Contact updated successfully";
            
        } else {
            $type = "warning";
            $op = "The contact was not been updated";
        }

        $this->dispatchBrowserEvent('closeContactModal');
        $this->emit('refreshCompanyContact');
        $this->emit('refreshBuildings');
        $this->emit('refreshContactShow');
        $this->emit(
            'alert', 
            [
                'type'=>$type,
                'message'=> $op,
            ]
        );
        
    }

    /**
     * Livetime validation
     * 
     * @return validation rules
     */
    public function rules() 
    {
        return [
            'telephone' => [
                Rule::requiredIf(empty($this->mobile) && empty($this->email)),
                'nullable','string','min:7','max:15'
            ],
            'mobile' => [
                Rule::requiredIf(empty($this->telephone) && empty($this->email)),
                'nullable','string','min:7','max:15'
            ],
            'email' => [
                'exclude_if:type,"primary"',
                Rule::requiredIf(empty($this->telephone) && empty($this->mobile)),
                'nullable','email:rfc,dns',
            ],
            'suite' => 'nullable|alpha_num',
            'num' => [
                Rule::requiredIf(!empty($this->suite) || !empty($this->street)),
                'nullable','numeric'
            ],
            'street' => [
                Rule::requiredIf(!empty($this->num) || !empty($this->city)),
                'nullable','string','min:2','max:32'
            ],
            'city' => [
                Rule::requiredIf(!empty($this->street) || !empty($this->country)),
                'nullable','string','min:2','max:32'
            ],
            'region' => 'nullable|string|min:2|max:32',
            'pc' => 'nullable|alpha_num',
            'country' => [
                Rule::requiredIf(!empty($this->city)),
                'nullable','string','min:2','max:32'
            ],
        ];
    }
    /**
     * Livetime validation
     * 
     * @param $propertyName to validate specific field
     * 
     * @return real time validation
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules());
    }
    
    /**
     * Updated Country
     *
     * @return void
     */
    public function updatedCountry()
    {
        $this->countryCities =  Countries::where('cca3', $this->country)->first()
            ->hydrate('cities')
            ->cities
            ->pluck('name', 'nameascii')
            ->toArray();

        $this->region = null;
        $this->city = null;

        $this->validate(
            [
                'country' => 'required|string|min:2|max:32'
            ]
        );
    }
    
    /**
     * Updated City
     *
     * @return void
     */
    public function updatedCity()
    {
        $myRegion =  Countries::where('cca3', $this->country)->first()
            ->hydrateCities()
            ->cities
            ->where('nameascii', $this->city)
            ->first()
            ->adm1name;
        $this->region = utf8_decode($myRegion);
        
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
                'oldContact',
                'suite',
                'num', 
                'street' ,
                'city',
                'region',
                'country', 
                'pc',
                'telephone',
                'mobile',
                'email',
                'countryCities'
            ]
        );
        $this->resetErrorBag();
    }

    /**
     * Edit Contact
     * 
     * @param Contact $newContact the new contact
     * 
     * @return Contact
     */
    public function edit(Contact $newContact)
    {
        //dd($newContact);
        $this->oldContact = $newContact;
        $this->contact_id = $this->oldContact->id;
        $this->suite = $this->oldContact->suite;
        $this->num = $this->oldContact->num;
        $this->street = $this->oldContact->street;
        $this->city = $this->oldContact->city;
        $this->region = $this->oldContact->region;
        $this->country = $this->oldContact->country;
        $this->pc = $this->oldContact->pc;
        $this->telephone = $this->oldContact->telephone;
        $this->mobile = $this->oldContact->mobile;
        $this->email = $this->oldContact->email;
        if (!empty($this->country)) {
            $this->countryCities =  Countries::where('cca3', $this->country)->first()
                ->hydrate('cities')
                ->cities
                ->pluck('name', 'nameascii')
                ->toArray();
        }
        
        $this->dispatchBrowserEvent('openContactModal');
    }
}
