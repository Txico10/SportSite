<?php
/** 
 * Employee Component
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

use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;
use PragmaRX\Countries\Package\Countries;

/**
 *  Extended Laratrust Roles Classe
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class EmployeesForm extends Component
{
    use WithFileUploads;
    public $currentStep;
    public $old_photo;
    public $photo;
    public $name;
    public $birthdate;
    public $gender;
    public $suite;
    public $number;
    public $street;
    public $city;
    public $region;
    public $country;
    public $zip;
    public $email;
    public $mobile;
    public $password;
    public $confirmPassword;
    public $role;
    public $roles;
    public $startDate;
    public $endDate;
    public $tcontract = 1;
    public $company;
    public $countryCities;
    public $allCountries;

    protected $listeners = ['resetEmployeeInputFields' => 'resetInputFields'];

    protected $rules = [
        'photo' => 'nullable|image|max:1024',
        'name' => 'required|string|min:3|max:191',
        'birthdate' => 'required|date',
        'suite' => 'nullable|alpha_num',
        'number' => 'required|numeric',
        'street' => 'required|string|min:2|max:32',
        'email' => 'required|email:rfc,dns|unique:users,email',
        'mobile' => 'required|string|min:7|max:15',
        'password' => 'required|alpha_num|min:6|max:32',
        'confirmPassword' => 'required|same:password',
        'role' => 'required|exists:roles,id',
        'startDate' => 'required|date|after_or_equal:today',
        'endDate' => 'nullable|date|after:startDate'
    ];

    /**
     * Mount
     * 
     * @param $company My company
     * 
     * @return void
     */
    public function mount($company)
    {
        $this->currentStep = 1;
        $this->country = "CAN";
        $this->allCountries = Countries::all()->pluck('name.common', 'cca3')
            ->toArray();
        $this->countryCities =  Countries::where('cca3', $this->country)->first()
            ->hydrate('cities')
            ->cities
            ->pluck('name', 'nameascii')
            ->toArray();
        $this->roles = Role::whereNotIn('id', [1,2,5])->get();
        $this->company = $company;
    }
    /**
     * Render
     *
     * @return void
     */
    public function render()
    {

        //dd($this->allCountries);
        return view(
            'livewire.management.employees-form', 
            [
                'countries' => $this->allCountries,
                'roles' => $this->roles,
            ]
        );
    }

        
    /**
     * Updated
     *
     * @param mixed $propertyName the property name
     * 
     * @return void
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Back step
     * 
     * @return previous step
     */
    public function myPreviousStep()
    {
        $this->currentStep -= 1;
    }

    /**
     * Fists step validation
     * 
     * @return validated fields
     */
    public function myNextStep()
    {
        
        if ($this->currentStep == 1) {
            $this->validate($this->rules1());
        }
        if ($this->currentStep == 2) {
            $this->validate($this->rules2());
        }
        if ($this->currentStep == 3) {
            //dump($this->tcontract);
            $this->validate($this->rules3());
        }
        
        $this->currentStep += 1;
    }
    
    /**
     * SubmitForm
     *
     * @return void
     */
    public function submitForm()
    {
        $employee = [
            'name' => $this->name,
            'birthdate' => $this->birthdate,
            'gender' => $this->gender,
        ];

        if (!empty($this->photo)) {
            //dd("Photo");
            $filename = Str::random() . time() . '.' . $this->photo->extension();
            $employee['image'] = $filename;
        }


        $address = [
            'num' => $this->number,
            'street' => $this->street,
            'city' => $this->city,
            'country' => $this->country,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'type' => 'primary',
        ];

        if (!empty($this->suite)) {
            $address['suite'] = $this->suite;
        }

        if (!empty($this->region)) {
            $address['region'] = $this->region;
        }

        if (!empty($this->zip)) {
            $address['pc'] = $this->zip;
        }
        

        $user = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'status' => '1',
        ];

        DB::beginTransaction();
        try {

            $newEmployee = Employee::create($employee);
            $newEmployee->contacts()->create($address);
            
            $newUser = User::create($user);
            $newUser->attachRole($this->role);

            $contract = [
                'user_id' => $newUser->id,
                'start_date' => $this->startDate,
            ];

            if (!empty($this->endDate)) {
                $contract['end_date'] = $this->endDate;
            }

            if ($this->tcontract == 1) {
                $contract['status'] = 'FT';
            } else {
                $contract['status'] = 'PT';
            }
            //dd($user);
            $this->company->employees()->attach($newEmployee->id, $contract);

            DB::commit();

            $newUser->sendEmailVerificationNotification();
            
            if (isset($employee['image'])) {
                $this->_storeImage($employee['image']);
            }
            
            //$this->dispatchBrowserEvent('closeEmployeeModal');
            $this->emit('refreshEmployees');

            $this->emit(
                'alert', 
                [
                    'type' => 'success',
                    'message' => 'Employee creted successfuly',
                ]
            );
        }catch(\Exception $ex) {
            DB::rollBack();
            $this->dispatchBrowserEvent('closeEmployeeModal');
            $this->emit(
                'alert', 
                [
                    'type' => 'error',
                    'message' => $ex->getMessage(),
                    ]
            );
        }
    }
    
    /**
     * StoreImage
     *
     * @param mixed $filename file name
     * 
     * @return void
     */
    private function _storeImage($filename)
    {
        $this->photo->storeAs('public/profile_images/employees', $filename);
        $path = public_path('storage/profile_images/employees/' . $filename);
        $width = 128;
        $height = 128;
        
        $img = Image::make($path)->resize(
            $width,
            $height,
            function ($constraint) {
                $constraint->aspectRatio();
            }
        );
        $img->save($path);
    }

    /**
     * Real time Country validation
     * 
     * @return validated country
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
     * UpdatedZip
     *
     * @return void
     */
    public function updatedZip()
    {
        return [
            'zip' => [
                Rule::requiredIf(
                    strcmp($this->country, 'CAN') == 0 ||
                        strcmp($this->country, 'USA') == 0 ||
                        strcmp($this->country, 'GBR') == 0
                ),
                'nullable', 'alpha_num',
            ],
        ];
    }
    
    /**
     * UpdatedTcontract
     *
     * @return void
     */
    public function updatedTcontract()
    {
        if ($this->tcontract==0) {
            //dd("YES");
            $this->reset(['endDate']);
        }
        
    }

    /**
     * Reset input fields
     * 
     * @return input reseted
     */
    public function resetInputFields()
    {
        $this->reset(
            [
                'old_photo',
                'photo',
                'name',
                'birthdate',
                'gender',
                'suite',
                'number',
                'street',
                'city',
                'region',
                'country',
                'zip',
                'email',
                'mobile',
                'password',
                'confirmPassword',
                'role',
                'startDate',
                'endDate',
            ]
        );
        $this->resetErrorBag();
        $this->currentStep = 1;
        $this->tcontract = 1;
        $this->country="CAN";
        $this->updatedCountry();
    }
    
    /**
     * Rules1
     *
     * @return void
     */
    public function rules1()
    {
        return [
            'photo' => ['nullable','image','max:1024'],
            'name' => ['required','string','min:3','max:191'],
            'birthdate' => ['required','date'],
            'gender' => Rule::in('M', 'F', 'O'),            
        ];
    }
        
    /**
     * Rules2
     *
     * @return void
     */
    public function rules2()
    {
        return [
            'suite'  => ['nullable','alpha_num'],
            'number' => ['required','numeric'],
            'street' => ['required','string','min:2','max:32'],
            'city'   => ['required','string','min:2','max:32'],
            'region' => [
                Rule::requiredIf(
                    strcmp($this->country, 'CAN') == 0 ||
                        strcmp($this->country, 'USA') == 0 ||
                        strcmp($this->country, 'GBR') == 0
                ),
                'nullable',
                'string',
                'min:2',
                'max:32'
            ],
            'country' => ['required','string','min:2','max:32'],
            'zip' => [
                Rule::requiredIf(
                    strcmp($this->country, 'CAN') == 0 ||
                    strcmp($this->country, 'USA') == 0 ||
                    strcmp($this->country, 'GBR') == 0
                ),
                'nullable', 'alpha_num',
            ],
        ];
    }
    
    /**
     * Roles3
     *
     * @return void
     */
    public function rules3()
    {
        return [
            'email' => 'required|email:rfc,dns|unique:users,email',
            'mobile' => 'required|string|min:7|max:15',
            'password' => 'required|alpha_num|min:6|max:32',
            'confirmPassword' => 'required|same:password',
            'role' => 'required|exists:roles,id',
            'startDate' => 'required|date|after_or_equal:today',
            'endDate' => [Rule::requiredIf($this->tcontract==0), 'nullable', 'date', 'after:startDate'],
        ];
    }

}
