<div class="card">
    <div class="card-header">
      <div class="card-tools">
        <div class="input-group input-group-sm" style="width: 150px;">
            <input type="text" wire:model="search" name="search" class="form-control float-right" placeholder="Search">
            <div class="input-group-append">
              <button class="btn btn-default"><i class="fas fa-search"></i></button>
            </div>
        </div>
      </div>
    </div>
    <div class="card-body">
      <table class="table table-hover text-wrap">
        <thead>
          <tr>
            <th>
              Photo
            </th>
            <th>
              <a wire:click.prevent="sortBy('name')" role="button" href="#">Name
                @include('includes._sort-icon', ['field' => 'name'])
              </a>
            </th>
            <th>
                <a wire:click.prevent="sortBy('birthdate')" role="button" href="#">Birthdate
                    @include('includes._sort-icon', ['field' => 'birthdate'])
                </a>
            </th>
            <th>
                <a wire:click.prevent="sortBy('gender')" role="button" href="#">Gender
                    @include('includes._sort-icon', ['field' => 'gender'])
                </a>
            </th>
            <th>
                <a wire:click.prevent="sortBy('display_name')" role="button" href="#">Role
                    @include('includes._sort-icon', ['field' => 'display_name'])
                </a>
            </th>
            <th>
              @permission('employee-create')
                <button class="btn btn-sm btn-outline-primary" type="button" style="width: 98px" data-toggle="modal" data-target="#modal-employee"><i class="fas fa-plus"></i> Add</button>
              @endpermission
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach($employees as $employee)
          <tr>
            <td>
              <ul class="list-inline">
                <li class="list-inline-item">
                    <img alt={{$employee->name}} class="table-avatar" style="width:40px;height:40px;" src={{!empty($employee->image) ? asset(Storage::url('profile_images/employees/'.$employee->image)): null}}>
                </li>
              </ul>
            </td>
            <td>{{$employee->name}}</td>
            <td>{{$employee->birthdate}}</td>
            <td>{{$employee->gender}}</td>
            <td>{{$employee->display_name}}</td>
            <td>
              <div class="margin">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-outline-secondary" wire:click.prevent="$emit('showEmployeeContact', {{$employee->id}})"><i class="fas fa-map-marker-alt"></i></button>
                </div>
                @permission('employee-update')
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-outline-info" wire:click.prevent="$emit('editEmployee', {{$employee}})"><i class="fas fa-pencil-alt"></i></button>
                  <button type="button" class="btn btn-sm btn-outline-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <div class="dropdown-menu" role="menu">
                    <a class="dropdown-item" wire:click.prevent="$emit('editContact', {{$employee->contacts}})" href="javascript:void(0)">Update Contact</a>
                    <a class="dropdown-item" href="#">Reset Password</a>
                  </div>
                </div>
                @endpermission
                @permission('employee-delete')
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i></button>
                  <button type="button" class="btn btn-sm btn-outline-danger dropdown-toggle dropdown-icon" data-toggle="dropdown">
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <div class="dropdown-menu" role="menu">
                    <a class="dropdown-item" href="#">Close file</a>
                    <a class="dropdown-item" href="#">Another action</a>
                  </div>
                </div>
                @endpermission
              </div>
            </td>
          </tr>  
          @endforeach
        </tbody>
      </table>
    <!-- /.card-body -->
    </div>
    <!-- /.card-footer-->
    {{ $employees->links() }}
    <x-modal title="Show contact" id="modal-showContact" type="" icon="fas fa-address-card">
      <livewire:management.contact-show/>
    </x-modal>
    <x-modal title="Contact" id="modal-contact" type="" icon="fas fa-address-book">
      <livewire:management.contact-form/>
    </x-modal>
    <x-modal title="Create Employee" id="modal-employee" type="modal-lg" icon="fas fa-user-plus">
      
    </x-modal>
    <x-modal title="Edit Employee" id="modal-editEmployee" type="" icon="fas fa-user-edit">
      <livewire:management.employees-edit />
    </x-modal>
<!-- /.card -->
</div>
    
