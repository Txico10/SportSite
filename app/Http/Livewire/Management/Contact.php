<?php
/** 
 * Company Contact component
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


use Livewire\Component;
/**
 *  Company contact management
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class Contact extends Component
{
    public $contact;

    protected $listeners = ['refreshCompanyContact'=> '$refresh'];
    /**
     * Mount company.
     * 
     * @param $contact company id
     *
     * @return view
     */
    public function mount($contact)
    {
        
        $this->contact = $contact;      
        
        //dd($this->contact->count());
    }

    /**
     * Display company contact.
     *
     * @return view
     */
    public function render()
    {
        return view(
            'livewire.management.contact', 
            [
                'contact' => $this->contact,
            ]
        );
    }
}
