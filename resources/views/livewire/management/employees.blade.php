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
            <td>{{$employee->name}}</td>
            <td>{{$employee->birthdate}}</td>
            <td>{{$employee->gender}}</td>
            <td>{{$employee->display_name}}</td>
            <td>
              <button type="button" class="btn btn-sm btn-outline-secondary" wire:click.prevent="$emit('showEmployeeContact', {{$employee->id}})"><i class="fas fa-map-marker-alt"></i></button>
              @permission('employee-update')
              <div class="btn-group">
                <button type="button" class="btn btn-sm btn-outline-info"><i class="fas fa-pencil-alt"></i></button>
                <button type="button" class="btn btn-sm btn-outline-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu" role="menu">
                  <a class="dropdown-item" href="#">Update Contact</a>
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
            </td>
          </tr>  
          @endforeach
        </tbody>
      </table>
    <!-- /.card-body -->
    </div>
    <!-- /.card-footer-->
    {{ $employees->links() }}
    <x-modal title="Show contact" id="modal-showContact" type="modal-md">
      <livewire:management.contact-show :contacts="$employee->contacts"/>
    </x-modal>
    <x-modal title="Create Employee" id="modal-employee" type="modal-lg">
      <livewire:management.employees-form :company="$company"/>
    </x-modal>
<!-- /.card -->
</div>
    
