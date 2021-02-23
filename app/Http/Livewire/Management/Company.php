<?php
/** 
 * Company component
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

use App\Models\RealState;
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
class Company extends Component
{
    public $company_id;

    protected $listeners = [
        'refreshCompany'=> '$refresh',
    ];

    /**
     * Display company contact.
     * 
     * @param $company company id
     *
     * @return view
     */
    public function mount($company)
    {
        $this->company_id = $company;
    }

    /**
     * Display company contact.
     *
     * @return view
     */
    public function render()
    {
        return view(
            'livewire.management.company', 
            [
                'company' => RealState::findOrFail($this->company_id),
            ]
        );
    }
}
