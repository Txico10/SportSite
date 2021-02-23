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

use App\Models\Contact as ModelsContact;
use App\Models\User;
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
class Contact extends Component
{
    public $user_id;

    protected $listeners = ['refreshContact'=> '$refresh'];
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
        $user = User::findOrFail($this->user_id);
        
        if ($user->contacts()->count() > 0) {
            $myContact = $user->contacts;
        } else {
            foreach ($user->employees as $employee) {
                $myContact = ModelsContact::where('contactable_type', 'App\Models\Employee')
                    ->where('contactable_id', $employee->id)->get();
            }
        }
        return view(
            'livewire.user.contact',
            [
                'user_id' => $this->user_id,
                'contacts' => $myContact,
            ]
        );
    }
}
