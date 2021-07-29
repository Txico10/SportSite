<?php

/**
 * Livewire Clients form Component
 *
 * PHP version 7.4
 *
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */

namespace App\Http\Livewire\Admin;

use App\Events\CompanyCreatedEvent;
use App\Models\Employee;
use App\Models\RealState;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use PragmaRX\Countries\Package\Countries;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;

/**
 *  Livewire clients form component
 *
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class ClientsForm extends Component
{
    use WithFileUploads;
    public $old_logo;
    public $logo;
    public $name;
    public $neq;
    public $legalform;
    public $suite;
    public $number;
    public $street;
    public $city;
    public $countryCities;
    public $region;
    public $country;
    public $zip;
    public $managerName;
    public $managerBirth;
    //public $managerNas;
    public $managerGender;
    public $managerEmail;
    public $managerMobile;
    public $managerPassword;
    public $managerConfirmPassword;
    public $currentStep = 1;
    public $allCountries;




    protected $listeners = ['resetNewCompanyInputFields' => 'resetInputFields'];

    /**
     * Mount
     *
     * @return void
     */
    public function mount()
    {
        $this->allCountries = Countries::all()->pluck('name.common', 'cca3')
            ->toArray();
        // $country = "CAN";
        // $state = 10;
        // $myCountry = Countries::all();
        // $teste = $myCountry->where('cca3', $country)->first()
        //     ->hydrateCities()
        //     ->cities
        //     ->where('admin1_cod', $state)
        //     ->pluck(utf8_encode('gn_ascii'), 'name');
        //$teste = $myCountry->where('cca3', 'CAN')
        // ->first()
        // ->hydrateStates()
        // ->states
        // ->sortBy('name');
        //$teste = $myCountry->where('cca3', $country)->first()
        //    ->hydrateCities()
        //    ->states
        //    ->cities
        //    ->where('adm1name', $state);
        //->sortBy('name');
        //->pluck('name', 'name.adm1name');
        //dd($teste);
    }

    /**
     * Render de livewire client form
     *
     * @return livewire_clientform
     */
    public function render()
    {
        return view(
            'livewire.admin.clients-form',
            [
                'countries' => $this->allCountries
            ]
        );
    }

    /**
     * Real time photo validation
     *
     * @return validated photo
     */
    public function updatedPhoto()
    {
        $this->validate(
            [
                'photo' => 'image|max:1024', // 1MB Max
            ]
        );
    }

    /**
     * Real time photo validation
     *
     * @return validated name
     */
    public function updatedName()
    {
        $this->validate(
            [
                'name' => 'required|string|min:3|max:191'
            ]
        );
    }

    /**
     * Real time NEQ validation
     *
     * @return validated neq
     */
    public function updatedNeq()
    {
        $this->validate(
            [
                'neq' => 'required|digits_between:8,9'
            ]
        );
    }

    /**
     * Real time suite validation
     *
     * @return validated Suite
     */
    public function updatedSuite()
    {
        $this->validate(
            [
                'suite' => 'nullable|alpha_num'
            ]
        );
    }

    /**
     * Real time Number validation
     *
     * @return validated number
     */
    public function updatedNumber()
    {
        $this->validate(
            [
                'number' => 'required|numeric'
            ]
        );
    }

    /**
     * Real time Number validation
     *
     * @return validated number
     */
    public function updatedStreet()
    {
        $this->validate(
            [
                'street' => 'required|string|min:2|max:32',
            ]
        );
    }

    /**
     * Real time City validation
     *
     * @return validated city
     */
    public function updatedCity()
    {
        if ($this->city != null) {
            $myRegion =  Countries::where('cca3', $this->country)->first()
                ->hydrateCities()
                ->cities
                ->where('nameascii', $this->city)
                ->first()
                ->adm1name;
            $this->region = utf8_decode($myRegion);
        } else {
            $this->region = null;
        }

        $this->validate(
            [
                'city' => 'required|string|min:2|max:32',
            ]
        );
    }

    /**
     * Real time City validation
     *
     * @return validated city
     */
    public function updatedRegion()
    {
        $this->validate(
            [
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
                ]
            ]
        );
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

        //dd($this->countryCities);

        $this->validate(
            [
                'country' => 'required|string|min:2|max:32'
            ]
        );
    }

    /**
     * Real time Zip code validation
     *
     * @return validated Zip Code
     */
    public function updatedZip()
    {
        $this->validate(
            [
                'zip' => [
                    Rule::requiredIf(
                        strcmp($this->country, 'CAN') == 0 ||
                            strcmp($this->country, 'USA') == 0 ||
                            strcmp($this->country, 'GBR') == 0
                    ),
                    'nullable',
                    'alpha_num',
                ],
            ]
        );
    }

    /**
     * Updated Manager Name
     *
     * @return void
     */
    public function updatedManagerName()
    {
        $this->validate(
            [
                'managerName' => 'required|string|min:7|max:191',
            ]
        );
    }

    /**
     * Updated Manager Birth
     *
     * @return void
     */
    public function updatedManagerBirth()
    {
        $this->validate(
            [
                'managerBirth' => 'required|date'
            ]
        );
    }

    /**
     * Real time Telephone number validation
     *
     * @return validated telephone number
     */
    public function updatedManagerMobile()
    {
        $this->validate(
            [
                'managerMobile' => 'required|string|min:7|max:15',
            ]
        );
    }

    /**
     * Real time Email validation
     *
     * @return validated email address
     */
    public function updatedManagerEmail()
    {
        $this->validate(
            [
                'managerEmail' => 'required|email:rfc,dns|unique:users,email',
            ]
        );
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
                'old_logo',
                'logo',
                'name',
                'neq',
                'legalform',
                'suite',
                'number',
                'street',
                'city',
                'countryCities',
                'region',
                'country',
                'zip',
                'managerName',
                'managerBirth',
                //'managerNas',
                'managerGender',
                'managerEmail',
                'managerMobile',
                'managerPassword',
                'managerConfirmPassword',
            ]
        );
        $this->resetErrorBag();
        $this->currentStep = 1;
    }

    /**
     * Rules for step 1
     *
     * @return validates rules
     */
    public function rules1()
    {
        return [
            'logo'      => ['image', 'max:1024'], // 1MB Max;,
            'name'      => ['required', 'string', 'min:3', 'max:191'],
            'neq'       => ['required', 'digits_between:8,9'],
            'country'   => ['required', 'string', 'min:2', 'max:32'],
            'legalform' => ['required', Rule::in(
                [
                    'Sole proprietorship',
                    'Business corporation',
                    'General partnership',
                    'Limited partnership',
                    'Cooperative'
                ]
            )],
        ];
    }

    /**
     * Rules for step 2 - Company Address
     *
     * @return validation rules for step 2
     */
    public function rules2()
    {
        return [
            'suite' => 'nullable|alpha_num',
            'number' => 'required|numeric',
            'street' => 'required|string|min:2|max:32',
            'city' => 'required|string|min:2|max:32',
            'region' => [
                Rule::requiredIf(
                    strcmp($this->country, 'CAN') == 0 ||
                        strcmp($this->country, 'USA') == 0 ||
                        strcmp($this->country, 'GBR') == 0
                ),
                'nullable', 'string', 'min:2', 'max:32'
            ],
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
     * Rule for step 3
     *
     * @return validated manager data
     */
    public function rules3()
    {
        return [
            'managerName' => 'required|string|min:7|max:191',
            'managerBirth' => 'required|date',
            'managerGender' => ['required', Rule::in(['M', 'F'])],
            'managerMobile' => 'required|string|min:7|max:15',
            'managerEmail' => 'required|email:rfc,dns|unique:users,email',
            'managerPassword' => 'required|alpha_num|min:6|max:32',
            'managerConfirmPassword' => 'required|same:managerPassword',

        ];
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
            $this->validate($this->rules3());
        }

        $this->currentStep += 1;
    }

    /**
     * Submit form
     *
     * @return void
     */
    public function submitForm()
    {
        //Create enterprise -> with Contact
        DB::beginTransaction();
        try {

            /**
             * Create new Company (RealState)
             */
            $filename = Str::random() . time() . '.' . $this->logo->extension();

            $clientData = [
                'name' => $this->name,
                'neq' => $this->neq,
                'legalform' => $this->legalform,
                'logo'=> $filename,
                'slug'=>Str::of($this->name)->slug('-'),
            ];

            $client = RealState::create($clientData);

            /**
             * Company Contact
             */
            $clientContact = [
                //'suite' => $this->suite,
                'num' => $this->number,
                'street' => $this->street,
                'city' => $this->city,
                //'region' => $this->region,
                'country' => $this->country,
                //'pc' => $this->zip,
                'email' => $this->managerEmail,
                'mobile' => $this->managerMobile,
                'type' => 'primary'
            ];

            if (!empty($this->suite)) {
                $clientContact['suite'] = $this->suite;
            }

            if (!empty($this->region)) {
                $clientContact['region'] = $this->region;
            }

            if (!empty($this->zip)) {
                $clientContact['pc'] = $this->zip;
            }

            $client->contact()->create($clientContact);

            /**
             * Create Team
             */
             $team = $client->team()->create(['display_name'=>$client->name]);

             /**
              * Create company first employee
              */
            $employee = [
                'name' => $this->managerName,
                'birthdate' => $this->managerBirth,
                //'nas' => '',//remove NAS from database
                'gender' => $this->managerGender,
            ];

            $newEmployee = Employee::create($employee);

            /**
             * Employee contact
             */
            $employeeContact = [
                'mobile' => $this->managerMobile,
                'email'  => Str::lower($this->managerEmail),
                'type' => 'primary',
            ];

            $newEmployee->contact()->create($employeeContact);

            /**
             * Employee user
             */
            $newUser = User::create(
                [
                    'name' => $this->managerName,
                    'email' => $this->managerEmail,
                    'password' => Hash::make($this->managerPassword),
                ]
            );

            /**
             * Assign administrator role to user
             */
            $role = Role::where("name", "administrator")->first();

            $newUser->attachRole($role, $team);

            /**
             * Contract registration
             */
            $contract = [
                'user_id' => $newUser->id,
                'start_date' => Carbon::now()->format('Y-m-d'),
                'api_token' => bin2hex(openssl_random_pseudo_bytes(16)),
                'status' => 'FT'
            ];

            //Register employee on enterprise and give role
            $client->employees()->attach($newEmployee->id, $contract);

            DB::commit();

            /**
             * Save Company image
             */
            $this->logo->storeAs('public/profile_images/companies', $filename);
            $path = public_path('storage/profile_images/companies/' . $filename);
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

            event(new Registered($newUser));
            event(new CompanyCreatedEvent($client));

            $msgtype = "success";
            $msg = "Client created successfully";

        } catch (\Throwable $th) {
            DB::rollBack();
            $msgtype = "error";
            $msg = $th->getMessage();
        }

        $this->dispatchBrowserEvent('closeClientModal');
        $this->emit('refreshClient');
        $this->emit(
            'alert',
            [
                'type' => $msgtype,
                'message' => $msg
            ]
        );

    }
}
