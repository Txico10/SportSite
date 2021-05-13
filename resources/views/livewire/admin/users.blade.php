
<div class="card">
  <div class="card-header">
    @permission('users-create')
    <button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#modal-userform"><i class="fas fa-plus"></i> Add User</button>
    @endpermission
    <div class="card-tools">
      <div class="input-group input-group-sm" style="width: 150px;">
        <input wire:model="search" type="text" name="search" class="form-control float-right" placeholder="Search">
        <div class="input-group-append">
          <button class="btn btn-default"><i class="fas fa-search"></i></button>
        </div>
      </div>
    </div>
  </div>
  <!-- /.card-header -->
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
      <thead>
        <tr>
          <th>#</th>
          <th>
            <a wire:click.prevent="sortBy('name')" role="button" href="#">Name
              @include('includes._sort-icon', ['field' => 'name'])
            </a>
          </th>
          <th>
            <a wire:click.prevent="sortBy('email')" role="button" href="#">
              Email
              @include('includes._sort-icon', ['field' => 'email'])
            </a>
          </th>
          <th>Role</th>
          <th>Company</th>
          <th>Created</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $key => $user)
          <tr>
            <td>{{$key + $users->firstItem()}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>
              @foreach($user->roles as $role)
                <span class="badge bg-success">{{ucfirst($role->display_name)}}</span>
              @endforeach
            </td>
            <td>
              @foreach($user->employees as $employee)
                {{$employee->pivot->myCompany->name}}
              @endforeach
            </td>
            <td>{{\Carbon\Carbon::parse($user->created_at)->diffForHumans()}}</td>
            <td>
                <button class="btn btn-sm btn-outline-primary" type="button" wire:click="$emit('infoUser',{{ $user->id }})"><i class="fas fa-user-cog"></i> Info</button>
                @if(Auth::id()!=$user->id)
                  @permission('users-update')
                  <button class="btn btn-sm btn-outline-info" type="button" wire:click="$emit('editUser',{{ $user->id }})"><i class="fas fa-pencil-alt"></i> Edit</button>
                  @endpermission
                  @permission('users-delete')
                  <button class="btn btn-sm btn-outline-danger" type="button" wire:click="$emit('triggerDeleteUser',{{$user->id}})"><i class="fas fa-trash-alt"></i> Delete</button>
                  @endpermission
                  @if($user->status==0)
                  <button class="btn btn-sm btn-outline-secondary type="button" wire:click="$emit('changeStatus',{{$user->id}})"><i class="fas fa-toggle-off"></i> Inactive</button>
                  @else
                  <button class="btn btn-sm btn-outline-success type="button" wire:click="$emit('changeStatus',{{$user->id}})"><i class="fas fa-toggle-on"></i>Active</button>
                  @endif
                @endif

            </td>
          </tr>
        @empty
          <div class="row">
            <p class="text-red float-rigth">No user registered</p>
          </div>  
        @endforelse
      </tbody>
    </table>
  </div>
  <!-- /.card-body -->
  {{ $users->links() }}   
</div>

<x-modal title="User" id="modal-userform" type="">
  <livewire:admin.users-form>
</x-modal>

<!-- Modal Info User-->
<div class="modal fade" id="modal-infoUser">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header bg-primary">
          <h4 class="modal-title">User info</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer float-right">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
          </div>
      </div>
  <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
  <!-- /.modal -->