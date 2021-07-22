@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.BootstrapSelect', true)
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
                                    <button class="btn btn-tool" id="userRolesPermissionsButton" value="{{$team->display_name}}">
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
        <div class="col-md-6">
            @php
                $heads = [
                  '#',
                  'Company',
                  'Type',
                  'Start date',
                  'End date',
                  'Action'
                ];
                $data = array();

                //dd($companies);
                foreach ($user->employees as $key=>$employee) {
                    $btn = '<a class="btn btn-outline-primary btn-sm mx-1 shadow" type="button" title="Agreement details" href="#"><i class="fas fa-info-circle fa-fw"></i></a>';
                    $mydata = [$key+1, $employee->pivot->myCompany->name, $employee->pivot->status==="FT"?"Full time":"Partial time", \Carbon\Carbon::parse($employee->pivot->start_date)->format('d F Y'), !empty($employee->pivot->end_date)?\Carbon\Carbon::parse($employee->pivot->end_date)->format('d F Y'):'', '<nobr>'.$btn.'</nobr>'];
                    array_push($data, $mydata);
                }

                //dd($data);
                $config = [
                  'data'=>$data,
                  'responsive'=> true,
                  'order' => [[1,'asc']],
                  'columns' => [null, null, null, null, null, ['orderable' => false]],
                ];
            @endphp
            <!-- Default box -->
            <div class="card">
                <div class="card-header bg-lightblue">
                    <h3 class="card-title">Employee</h3>
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
                    <x-adminlte-datatable id="contractTable" :heads="$heads" :config="$config" compressed/>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-3">
            <livewire:management.contact :contact="$user->employees->last()->contact" />
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
@stop