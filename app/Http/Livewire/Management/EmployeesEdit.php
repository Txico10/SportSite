<?php
/** 
 * Employee form
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
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

/**
 *  Employee form class
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class EmployeesEdit extends Component
{
    use WithFileUploads;
    public $myEmployee;
    public $image;
    public $old_image;
    public $name;
    public $birthdate;
    public $gender;

    protected $listeners = [
        'editEmployee'=> 'edit',
        'resetEditEmployeeInputFields' => 'resetInputFields' 
    ];
        
    /**
     * Rules
     *
     * @return void
     */
    protected function rules()
    {
        return [
            'image' => ['required','image','mimes:jpg,png,jpeg,gif,svg','max:2048','dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'],
            'name' => ['required','string','min:3','max:191'],
            'birthdate' => ['required','date', 'before:today'],
            'gender' => Rule::in('M', 'F', 'O')
        ];
    } 
    /**
     * Render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.management.employees-edit');
    }
    
    /**
     * Updated
     *
     * @param mixed $propertyName validation field
     * 
     * @return void
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Edit
     *
     * @param Employee $employee the employee
     * 
     * @return void
     */
    public function edit(Employee $employee)
    {
        $this->myEmployee = $employee;
        $this->image = $employee->image;
        $this->old_image = $employee->image;
        $this->name = $employee->name;
        $this->birthdate = $employee->birthdate;
        if (strcmp($employee->gender, "male")==0) {
            $this->gender = "M";
        } else {
            if (strcmp($employee->gender, "female")==0) {
                $this->gender = "F";
            } else {
                $this->gender = "O";
            }
        }

        $formatedDate = Carbon::parse($this->birthdate)->format('d-m-Y');
        $this->dispatchBrowserEvent('openEmployeeEditModal', ['birthdate' => $formatedDate]);
    }
    
    /**
     * ResetInputFields
     *
     * @return void
     */
    public function resetInputFields()
    {
        $this->reset();
        $this->resetErrorBag();
    }
        
    /**
     * SaveEmployeeEdit
     *
     * @return void
     */
    public function saveEmployeeEdit()
    {
        $data = $this->validate();
        $this->myEmployee->name = $data['name'];
        $this->myEmployee->birthdate = $data['birthdate'];
        $this->myEmployee->gender = $data['gender'];
        //remove existing image
        if (strcmp($this->image, $this->old_image)!=0) {
            Storage::delete('public/profile_images/employees/'.$this->old_image);
            $filename = Str::random() . time() . '.' . $this->image->extension();
            $this->myEmployee->image = $filename;
            $this->_storeImage($filename);
        }
        
        $this->myEmployee->save();
        $this->dispatchBrowserEvent('closeEmployeeEditModal');
            $this->emit('refreshEmployees');
            $this->emit(
                'alert', 
                [
                    'type' => 'success',
                    'message' => 'Employee updated successfuly',
                ]
            );
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
        $this->image->storeAs('public/profile_images/employees', $filename);
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
}
