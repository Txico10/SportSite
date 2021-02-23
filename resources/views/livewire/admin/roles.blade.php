<div class="card">
    <div class="card-header">
        @permission('roles-create')        
        <button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#modal-roles"><i class="fas fa-plus"></i> Add Role</button>  
        @endpermission
        <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
                <input wire:model="search_role" type="text" name="search" class="form-control float-right" placeholder="Search role">
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
                    </th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($roles->count())
                    @foreach($roles as $key=>$role)
                        <tr>
                            <td>{{$key + $roles->firstItem()}}</td>
                            <td>{{$role->display_name}}</td>
                            <td>{{$role->description}}</td>
                            <td>{{$role->name}}</td>
                            <td>{{\Carbon\Carbon::parse($role->created_at)->diffForHumans()}}</td>
                            <td>{{\Carbon\Carbon::parse($role->updated_at)->diffForHumans()}}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-info" role="button" wire:click="$emit('infoRole',{{ $role->id }})"><i class="fas fa-info-circle"></i></button>
                                    @permission('roles-update')
                                    <button class="btn btn-outline-secondary" role="button" wire:click="$emit('editRole',{{ $role->id }})"><i class="fas fa-pencil-alt"></i></button>
                                    @endpermission
                                    @permission('roles-delete')
                                    <button class="btn btn-outline-danger" role="button" wire:click.prevent="$emit('triggerDeleteRole',{{$role->id}})"><i class="fas fa-trash-alt"></i></button>
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
    {{ $roles->links() }}
</div>

<x-modal title="Roles" id="modal-roles" type="">
    <livewire:admin.roles-form/>
</x-modal>

<!-- Modal Roles Info-->
<div class="modal fade" id="modal-rolePerms">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
            <h4 class="modal-title">Role info</h4>
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

