<div class="card">
    <div class="card-header">
        @permission('permissions-create')
        <button class="btn btn-outline-primary" data-toggle="modal" data-target="#modal-permissions" href="#"><i class="fas fa-plus"></i> New Permission</button>
        @endpermission
        <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 160px;">
                <input wire:model="search_permission" type="text" name="search" class="form-control float-right" placeholder="Search permission">
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
                        <a wire:click.prevent="sortBy('display_name')" role="button" href="#">Name
                        @include('includes._sort-icon', ['field' => 'display_name'])
                        </a>
                    </th>
                    <th>
                        <a wire:click.prevent="sortBy('description')" role="button" href="#">Description
                        @include('includes._sort-icon', ['field' => 'description'])
                        </a>
                    </th>
                    <th>
                        <a wire:click.prevent="sortBy('name')" role="button" href="#">Tag
                            @include('includes._sort-icon', ['field' => 'name'])
                        </a>
                    </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($permissions->count())
                    @foreach($permissions as $key=>$permission)
                        <tr>
                            <td>{{$key + $permissions->firstItem()}}</td>
                            <td>{{$permission->display_name}}</td>
                            <td>{{$permission->description}}</td>
                            <td>{{$permission->name}}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a class="btn btn-outline-info" type="button" wire:click="$emit('infoPermission',{{ $permission->id }})" href="#"><i class="fas fa-info-circle"></i></a>
                                    @permission('permissions-update')
                                    <a class="btn btn-outline-secondary" type="button" wire:click="$emit('editPermission',{{ $permission->id }})" href="#"><i class="fas fa-pencil-alt"></i></a>
                                    @endpermission
                                    @permission('permissions-delete')
                                    <a class="btn btn-outline-danger" type="button" wire:click="$emit('triggerDeletePermision',{{$permission->id}})" href="#"><i class="fas fa-trash-alt"></i></a>
                                    @endpermission
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <p>No user registered</p>
                @endif
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    {{ $permissions->links() }}
</div>

<x-modal title="Permissions" id="modal-permissions" type="" icon="fas fa-user-tag">
    <livewire:admin.permissions-form/>
</x-modal>


<!-- Modal Permissions info -->
<div class="modal fade" id="modal-permissionInfo">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary">
        <h4 class="modal-title">Permissions</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
  <!-- /.modal -->