@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', 'User details' )
@section('content_header')
    <h1></h1>
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">User information</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item"><a href="{{route('admin.users')}}">Users</a></li>
              <li class="breadcrumb-item active">Show</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@stop

@section('content')
<div class="container-fluid">
    @if($user->hasRole('superadministrator'))
    <div class="row">
        <div class="col-md-3">
            <x-adminlte-profile-widget name="{{$user->name}}" desc="{{$user->roles->last()->display_name}}" theme="lightblue"
                img="{{!empty($user->image)? asset('storage/profile_images/'.$user->image) :'https://picsum.photos/id/1/100'}}" layout-type="classic">
                <x-adminlte-profile-row-item icon="fas fa-fw fa-user-check" class="mr-1 border-bottom" title="Status" text="{{$user->status?'Active':'Inactive'}}"/>
                <x-adminlte-profile-row-item icon="fas fa-fw fa-envelope" class="mr-1 border-bottom" title="Email" text="{{$user->email}}"/>
                <x-adminlte-profile-row-item icon="fas fa-fw fa-key" class="mr-1 mb-2" title="Token" text="{{Str::limit($user->api_token, 25, '...')}}"/>
                <x-adminlte-button id="editProfileButton" label="Edit user" class="btn-block"  theme="primary" />
            </x-adminlte-profile-widget>
        </div>
        <div class="col-md-6">

        </div>
        <div class="col-md-3">

        </div>
    </div>
    @else
    <div class="row">
        <div class="col-md-3">
            <!-- User profile -->
            <x-adminlte-profile-widget name="{{$user->name}}" desc="{{$user->roles->last()->display_name}}" theme="lightblue"
                img="{{!empty($user->image)? asset('storage/profile_images/'.$user->image) :'https://picsum.photos/id/1/100'}}" layout-type="classic">
                <x-adminlte-profile-row-item icon="fas fa-fw fa-venus-mars" class="mr-1 border-bottom" title="Gender" text="{{ucfirst($user->employees->last()->gender)}}"/>
                <x-adminlte-profile-row-item icon="fas fa-fw fa-birthday-cake" class="mr-1 border-bottom" title="Birthdate" text="{{\Carbon\Carbon::parse($user->employees->last()->birthdate)->format('d F Y')}}"/>
                <x-adminlte-profile-row-item icon="fas fa-fw fa-user-check" class="mr-1 border-bottom" title="Status" text="{{$user->status?'Active':'Inactive'}}"/>
                <x-adminlte-profile-row-item icon="fas fa-fw fa-envelope" class="mr-1 border-bottom" title="Email" text="{{$user->email}}"/>
                <x-adminlte-profile-row-item icon="fas fa-fw fa-key" class="mr-1 mb-2" title="Token" text="{{Str::limit($user->api_token, 25, '...')}}"/>
                <x-adminlte-button id="editProfileButton" label="Edit user" class="btn-block"  theme="primary" />
            </x-adminlte-profile-widget>
        </div>
        <div class="col-md-6">
            @php
                $heads = [
                    '#',
                    'IP Address',
                    'Login',
                ];

                $config = [
                    'processing' => true,
                    'serverSide' => true,
                    'ajax' => ['headers'=> ['X-CSRF-TOKEN'=>csrf_token()], 'url'=> route('admin.users.show', ['user'=>$user])],
                    //'data'=>$data,
                    'responsive'=> true,
                    'order' => [[0,'asc']],
                    'columns' => [['data'=>'DT_RowIndex', 'searchable'=>false], ['data'=>'ip_address'], ['data'=>'created_at']],
                ]
            @endphp
            <!-- Default box -->
            <div class="card">
                <div class="card-header bg-lightblue">
                    <h3 class="card-title">Logins</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <x-adminlte-datatable id="contractTable" :heads="$heads" :config="$config"/>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-3">
            <!-- /.User profile -->
            <!-- Default box -->
            <div class="card card-row card-lightblue">
                <div class="card-header">
                    <h3 class="card-title">Roles and permissions</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @foreach($teams as $key => $team)
                        <!-- Roles and Permissions Box -->
                        <div class="card card-outline">
                            <div class="card-header bg-gray">
                                <h5 class="card-title">{{$team->display_name}}</h5>
                                @if(Auth::id()!=$user->id && $user->status!=0 && $user->active_company!=null)
                                <div class="card-tools">
                                    <button class="btn btn-tool" id="userRolesPermissionsButton" value="{{$team->id}}">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                </div>
                                @endif
                            </div>
                            <div class="card-body">
                                <strong><i class="fas fa-fw fa-user-tag mr-1"></i> Roles</strong>
                                <p>
                                    @foreach($user->roles as $role)
                                        @if($role->pivot->team_id==$team->id)
                                            <span class="badge bg-success">{{ucfirst($role->display_name)}}</span>
                                        @endif
                                    @endforeach
                                </p>
                                <hr>
                                <strong><i class="fas fa-fw fa-user-cog mr-1"></i> Permissios</strong>
                                <p>
                                    @foreach($user->permissions as $permission)
                                        @if($permission->pivot->team_id==$team->id)
                                            <span class="badge bg-success">{{$permission->display_name}}</span>
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                        </div>
                        <!-- /.card -->
                    @endforeach
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    @endif
    <x-modal title="Edit User" id="modal-profile" type="" icon="fas fa-user-secret">
        <livewire:user.profile-form :user="$user" />
    </x-modal>

    <x-modal title="Roles and Permissions" id="modal-user-roles-permissions" type="" icon="fas fa-user-tag">
        @include('form.user-role-permissions-form')
    </x-modal>

</div>
@stop

@section('footer')
    @include('includes.footer')
@stop

@section('js')
<script type="text/javascript" src="{{asset('js/company.js')}}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#user-role-form').select2({
        width: 'resolve',
        theme: 'bootstrap4',
        ajax : {
            url:"{{route('users.roles.list', ['user'=>$user])}}",
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function(params){
                return {
                    search: params.term,
                }
            },
            processResults: function(response) {
                return {results:response}
            },
            cache: true,
        }
    });

    $('#user-permissions-form').select2({
        width: 'resolve',
        theme: 'bootstrap4',
        placeholder: 'Select permissions',
        ajax : {
            url:"{{route('users.permissions.list', ['user'=>$user])}}",
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function(params){
                return {
                    search: params.term,
                }
            },
            processResults: function(response) {
                return {results:response}
            },
            cache: true,
        }
    });

    $("#userRolesPermissionsButton").on('click', function (event) {

        $.ajax({
            url:"{{route('users.rolesprofiles.fill', ['user'=>$user])}}",
            type: "POST",
            cache: false,
            data: {
                team_id: $(this).val(),
            },
            success: function(response) {
                $("#myteamID").val(response.team.id)
                $("#myteam").val(response.team.name)

                $.each(response.roles, function (key, value) {
                    //console.log(value)
                    // Set the value, creating a new option if necessary
                    if ($('#user-role-form').find("option[value='" + value.id + "']").length) {
                        $('#user-role-form').val(value.id).trigger('change');
                    } else {
                        // Create a DOM Option and pre-select by default
                        var newOption = new Option(value.text, value.id, value.selected, true);
                        // Append it to the select
                        $('#user-role-form').append(newOption).trigger('change');
                    }
                });

                $.each(response.permissions, function (key, value) {
                    //console.log(value)
                    // Set the value, creating a new option if necessary
                    if ($('#user-permissions-form').find("option[value='" + value.id + "']").length) {
                        $('#user-permissions-form').val(value.id).trigger('change');
                    } else {
                        // Create a DOM Option and pre-select by default
                        var newOption = new Option(value.text, value.id, value.selected, true);
                        // Append it to the select
                        $('#user-permissions-form').append(newOption).trigger('change');
                    }
                });

                $("#modal-user-roles-permissions").modal('show');
            },
            error: function(response){
                console.log(response);
                //$.each(response.responseJSON.errors, function(key, value){
                //  toastr["error"](value);
                //})
            }
        })
    });

    $("#user-role-permissions-form").submit(function(event){
        event.preventDefault();

        var formData = {
            team_id: $("#myteamID").val(),
            roles: $("#user-role-form").val(),
            permissions: $("#user-permissions-form").val()
        }
        //console.log(formData)
        $.ajax({
            url:"{{route('users.rolesprofiles.update', ['user'=>$user])}}",
            type: "PATCH",
            dataType: "json",
            cache: false,
            data: formData,
            success: function(response) {
                $("#modal-user-roles-permissions").modal('hide');
                toastr.options.onHidden = function() { location.reload() }
                toastr[response.type](response.message);
                //setTimeout(function () { location.reload(); 5000});
            },
            error: function(response, textStatus){
                //console.log(jqXHR)
                //console.log(textStatus)
                $.each(response.responseJSON.errors, function(key, value){
                    toastr[textStatus](value);
                })
            }
        });
    });

</script>
@stop
