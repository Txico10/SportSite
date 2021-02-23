<div class="card">
    <div class="card-header">
      @permission('building-create')
      <button class="btn btn-sm btn-outline-primary" type="button"><i class="fas fa-plus"></i> Add Employee</button>
      @endpermission
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
                <a wire:click.prevent="sortBy('nas')" role="button" href="#">NAS
                    @include('includes._sort-icon', ['field' => 'nas'])
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
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($employees as $employee)
          <tr>
            <td>{{$employee->name}}</td>
            <td>{{$employee->birthdate}}</td>
            <td>{{$employee->nas}}</td>
            <td>{{$employee->gender}}</td>
            <td>{{$employee->display_name}}</td>
            <td>
              @permission('employee-update')
              <button class="btn btn-sm btn-outline-info" type="button"><i class="fas fa-pencil-alt"></i></button>
              @endpermission
              @permission('employee-delete')
                <button class="btn btn-sm btn-outline-danger" type="button"><i class="fas fa-trash-alt"></i></button>
              @endpermission
            </td>
          </tr>  
          @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
    {{ $employees->links() }}
    <!-- /.card-footer-->
</div>
<!-- /.card -->    
