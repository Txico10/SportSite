<?php
/** 
 * Show Contact Component
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
use Livewire\Component;

/**
 *  Extended Laratrust Roles Classe
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class ContactShow extends Component
{
    public $contacts;

    protected $listeners = [
        'refreshContactShow' => '$refresh',
        'showEmployeeContact', 
    ];
    
    /**
     * Render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.management.contact-show');
    }

        
    /**
     * ShowContact
     *
     * @param Employee $employee employee info
     * 
     * @return void
     */
    public function showEmployeeContact(Employee $employee)
    {
        $this->contacts = $employee->contacts;
        $html = '<div class="card">
        <div class="card-header border-0">
          <h3 class="card-title">'.$employee->name.'</h3>
          <div class="card-tools">
            <a href="#" class="btn btn-sm btn-tool">
              <i class="fas fa-download"></i>
            </a>
            <a href="#" class="btn btn-sm btn-tool">
              <i class="fas fa-bars"></i>
            </a>
          </div>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
            <p class="text-lightblue text-lg">
              <i class="fas fa-map-marker-alt"></i>
            </p>
            <p class="d-flex flex-column text-right">
              <span class="font-weight-bold">
              '.$this->contacts[0]->suite.', '.$this->contacts[0]->num.' '.$this->contacts[0]->street.' <br> '.$this->contacts[0]->city.', '.$this->contacts[0]->region.' <br> '.$this->contacts[0]->country.', '.$this->contacts[0]->pc.'
              </span>
              <span class="text-muted">ADDRESS</span>
            </p>
          </div>
          <!-- /.d-flex -->
          <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
            <p class="text-lightblue text-lg">
              <i class="fas fa-phone-alt"></i>
            </p>
            <p class="d-flex flex-column text-right">
              <span class="font-weight-bold">
              '.$this->contacts[0]->telephone.'
              </span>
              <span class="text-muted">PHONE</span>
            </p>
          </div>
          <!-- /.d-flex -->
          <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
            <p class="text-lightblue text-lg">
              <i class="fas fa-mobile-alt"></i>
            </p>
            <p class="d-flex flex-column text-right">
              <span class="font-weight-bold">
              '.$this->contacts[0]->mobile.'
              </span>
              <span class="text-muted">MOBILE</span>
            </p>
          </div>
          <!-- /.d-flex -->
          <div class="d-flex justify-content-between align-items-center mb-0">
            <p class="text-lightblue text-lg">
              <i class="fas fa-at"></i>
            </p>
            <p class="d-flex flex-column text-right">
              <span class="font-weight-bold">
              '.$this->contacts[0]->email.'
              </span>
              <span class="text-muted">EMAIL</span>
            </p>
          </div>
          <!-- /.d-flex -->
        </div>
      </div>';
        $html = preg_replace('/\>\s+\</m', '><', $html);   
        $this->emit('contactInfo', $html);
    }
}
