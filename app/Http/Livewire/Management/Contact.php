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
        //dd($contact->count());
        //$this->company = $company->load('contact');
        //if (is_array($contact)) {
        //    dd("YES");
        //} else {
            $this->contact = $contact->first();      
        //}
        
        //dd($this->contact);
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
