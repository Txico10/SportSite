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

use App\Rules\CustomPasswordCheck;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 *  Profile form class
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class ProfileForm extends Component
{
    use WithFileUploads;

    public $user;
    public $name;
    public $email;
    public $old_email;
    public $photo;
    public $old_photo;
    public $password;
    public $hashed_password;
    public $submit_btn_title;

    protected $listeners = [
        'editProfile', 
        'resetProfileInputFields' => 'resetInputFields'
    ];

    /**
     * Mount profile form
     * 
     * @param $id user id
     * 
     * @return profile form
     */
    public function mount($user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->old_email = $user->email;
        $this->photo = $user->image;
        $this->old_photo = $user->image;
        $this->hashed_password = $user->password;
        $this->submit_btn_title = "update";
    }

    /**
     * Photo validation
     * 
     * @return profile form
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
     * Fields validation
     * 
     * @param $propertyName input field
     * 
     * @return profile form
     */
    public function updated($propertyName)
    {
        $validatedFields = [
            'name' => ['required','string','min:5','max:191'],
        ];

        if (strcmp($this->email, $this->old_email)!=0) {
            $validatedFields = array_merge(
                $validatedFields, 
                [
                    'email' => ['required','email:rfc,dns','max:255','unique:users'],
                    'password' => [
                        'required', 
                        'string', 
                        'min:6',
                        new CustomPasswordCheck($this->hashed_password),

                    ],
                ]
            );
        }

        $this->validateOnly($propertyName, $validatedFields);
    }

    /**
     * Render the livewire profile form view
     * 
     * @return profile form
     */
    public function render()
    {
        return view('livewire.user.profile-form');
    }

    /**
     * Render the livewire contact view
     * 
     * @return user_contact
     */
    public function editProfile()
    {

        $this->name = $this->user->name;
        $this->photo = $this->user->image;
        $this->email = $this->user->email;

        $this->dispatchBrowserEvent(
            'openModalProfile'
        );
        
    }

    /**
     * Reset input filds
     * 
     * @return void
     */
    public function resetInputFields()
    {
        $this->reset(['name','email','photo', 'password',]);
        $this->resetErrorBag();
    }

    /**
     * Save form data
     * 
     * @return void
     */
    public function saveForm()
    {
        $user = $this->user;

        if (strcmp($this->name, $user->name)!=0) {
            $user->name = $this->name;
            
        }

        if (strcmp($this->email, $user->email)!=0) {
            $user->email = $this->email;
            $user->email_verified_at = null;
        }

        if (strcmp($this->photo, $this->old_photo)) {

            if ($user->image) {
                //dd($user->getOriginal('image'));
                Storage::delete('public/profile_images/'.$user->image);
            }

            $filename = Str::random().time().'.'.$this->photo->extension();

            $this->photo->storeAs('public/profile_images', $filename);


            $user->image = $filename;

            $path = public_path('storage/profile_images/'.$filename);
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

        if ($user->isDirty()) {
            $email = $user->getOriginal('email'); 
            $user->save();

            if (strcmp($user->image, $this->old_photo)!=0) {
                $this->old_photo = $user->image;
                $this->photo = $user->image;
            }

            if (strcmp($user->email, $email)!=0) {
                $user->sendEmailVerificationNotification();
            }

            $message = "Profile updated successfully";
            $type = "success";
        } else {
            $message = "Profile not updated";
            $type = "warning";
        }

        
        $this->dispatchBrowserEvent('closeModalProfile');
        $this->emit('refreshProfile');
        $this->emit(
            'alert', 
            [
                'type'=>$type,
                'message'=>$message
            ]
        );
    }
}
