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
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
/**
 *  Reset password form class
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class ResetPassword extends Component
{
    public $user_id;
    public $oldpassword;
    public $new_password;
    public $new_password_confirmation;
    public $hashed_password;

    protected $listeners = [ 
        'resetPasswordInputFields' => 'resetInputFields'
    ];

    /**
     * Mount function
     * 
     * @return void
     */
    public function mount()
    {
        $this->user_id = auth()->user()->id;
        $this->hashed_password = auth()->user()->password;
        
    }

    /**
     * Rules validation
     * 
     * @return valideted field
     */
    public function rules()
    {
        
        return [
            'oldpassword' => [
                'required',
                'string', 
                'min:6',
                new CustomPasswordCheck($this->hashed_password),
            ],
            'new_password' => [
                'required','string','min:8','different:oldpassword'
            ],
            'new_password_confirmation' => [
                'required','string','min:8','same:new_password'
            ],
        ];
        
    }
    /**
     * Live validation
     * 
     * @param $propertyName name of the field
     * 
     * @return validation rules
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules());
    }

    /**
     * Render the livewire reset password
     * 
     * @return reset password
     */
    public function render()
    {
        return view('livewire.user.reset-password');
    }

    /**
     * Reset password form
     * 
     * @param $user_id user id
     * 
     * @return reset password
     */
    

    /**
     * Reset input filds
     * 
     * @return void
     */
    public function resetInputFields()
    {
        $this->reset(['oldpassword','new_password','new_password_confirmation']);
        $this->resetErrorBag();
    }

    /**
     * Reset password save
     * 
     * @return void
     */
    public function savePassword()
    {
        $this->validate($this->rules());

        $user = User::findOrFail($this->user_id);
        $user->password = Hash::make($this->new_password);
        $user->save();
        $this->hashed_password = $user->password;

        $this->dispatchBrowserEvent('closeModalResetPassword');
        $this->emit(
            'alert', 
            [
                'type'=>'success',
                'message'=>'Password updated successfully'
            ]
        );
    }
}
