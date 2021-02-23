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

use App\Models\User;
use Livewire\Component;

/**
 *  Profile class
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class Profile extends Component
{

    public $user_id;

    protected $listeners = ['refreshProfile'=> '$refresh'];

    
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
        return view(
            'livewire.user.profile', 
            [
                'user' => User::findOrFail($this->user_id),
            ] 
        );
    }
}
