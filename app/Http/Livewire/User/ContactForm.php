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
namespace App\Http\Livewire\User;

use App\Models\Contact;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Validation\Rule;
use Livewire\Component;
/**
 *  Users class
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class ContactForm extends Component
{
    public $submit_btn_title = "save";
    public $user_id;
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
    public $name;
    public $relationship;
    public $type;
    public $email;

    protected $listeners = [
        'editContact', 
        'resetContactInputFields' => 'resetInputFields',
        'deleteContact'
    ];

    /**
     * Mount the view for a specific user
     * 
     * @param $id user id
     * 
     * @return user_contact
     */
    public function mount($id) 
    {
        $this->user_id = $id;
    }

    /**
     * Render the livewire contact view
     * 
     * @return user_contact
     */
    public function render()
    {
        return view('livewire.user.contact-form');
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
            'suite','num','street','city', 'region', 'country', 'pc', 
            'telephone', 'mobile', 'name', 'relationship', 'type', 'email'
            ]
        );
        $this->resetErrorBag();
        $this->submit_btn_title = "save";
    }

    /** 
     * Edit Contact
     * 
     * @param $id contact id
     * 
     * @return view|user 
     */
    public function editContact($id)
    {
        $user = User::findOrFail($this->user_id);

        $contact = Contact::findOrFail($id);

        //dd($contact);
        $this->contact_id = $contact->id;
        $this->suite = $contact->suite;
        $this->num = $contact->num;
        $this->street = $contact->street;
        $this->city = $contact->city;
        $this->region = $contact->region;
        $this->country = $contact->country;
        $this->pc = $contact->pc;
        $this->telephone = $contact->telephone;
        $this->mobile = $contact->mobile;
        if (strcmp($contact->type, "primary")==0) {
            $this->name = $user->name;
            $this->email = $user->email;
        } else {
            $this->name = $contact->name;
            $this->email = $contact->email;
        }
        
        $this->relationship = $contact->relationship;
        $this->type = $contact->type;

        $this->submit_btn_title = "update";
    

        $this->dispatchBrowserEvent(
            'openContactModal',
            [
                'type' => $this->type,
                'relationship' => $this->relationship,
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
            'type' => ['required', Rule::in(['primary', 'emergency', 'other'])],
            'name' => 'exclude_if:type,"primary"|required|string|min:3|max:255',
            'relationship' => [
                'exclude_if:type,"primary"','required',
                Rule::in(['parent','child','spouse','friend','other'])
            ],
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
     * Save and update contact
     * 
     * @return contact saved
     */
    public function saveContactForm()
    {
        $op ="";

        $user = User::findOrFail($this->user_id);

        if (strcmp($this->submit_btn_title, "save")==0) {

            $validatedData = $this->validate($this->rules());

            //dd($validatedData);
            
            if ($user->employees->isEmpty()) {
                $user->contacts()->create($validatedData);
            } else {
                $today = Carbon::now();
                foreach ($user->employees as $employee) {
                    $date = Carbon::create($employee->pivot->end_date);
                    if ($today->lessThanOrEqualTo($date)) {
                        $employee->contact()->create($validatedData);
                    } 
                }
            }
            $op = "created";
        } else {
            $validatedData = $this->validate($this->rules());
            Contact::where('id', $this->contact_id)->update($validatedData);
            $op = "updated";
        }

        $this->dispatchBrowserEvent('closeContactModal');
        $this->emit('refreshContact');
        $this->emit(
            'alert', 
            [
                'type'=>'success',
                'message'=>'Contact '.$op.' successfully'
            ]
        );

    }

    /**
     * Delete Contact
     * 
     * @param $id contact to be deleted
     * 
     * @return real time validation
     */
    public function deleteContact($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        $this->emit('refreshContact');
        $this->emit(
            'alert', 
            [
                'type'=>'success',
                'message'=>'Contact deleted successfully'
            ]
        );

    }

}
