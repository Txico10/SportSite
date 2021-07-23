@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.BootstrapSelect', true)
@section('title', 'Users')
@section('content_header')
    <h1></h1>
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Users List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@stop

@section('content')
@php
  $heads = [
    '#',
    'Name',
    'Email',
    'Roles',
    'Company',
    'Last login',
    'Action',
  ];

  $data = array();
  $count = 0;
  //dd($companies);
  foreach ($users as $user) {
    $btn = null;
    
    $btn = '<a class="btn btn-sm btn-outline-primary mx-1 shadow" type="button" title="More details" href="'.route('admin.users.show', ['user'=>$user]).'"><i class="fas fa-user-cog fa-fw"></i></a>';
    
    if(Auth::id()!=$user->id) {
      if(Auth::user()->isAbleTo('users-delete') && !$user->hasRole('superadministrator')){
        $btn = $btn.'<button class="btn btn-sm btn-outline-danger mx-1 shadow userDelete" type="button" value="'.$user->id.'" title="Delete User"><i class="fas fa-trash-alt fa-fw"></i></button>';
      }
      if($user->status==0){
        $btn = $btn.'<button class="btn btn-sm btn-outline-secondary mx-1 shadow changeStatus" type="button" value = "'.$user->id.'" title="Inactive User"><i class="fas fa-toggle-off fa-fw"></i></button>';
      }else {
        $btn = $btn.'<button class="btn btn-sm btn-outline-success mx-1 shadow changeStatus" type="button" value = "'.$user->id.'" title="Active User"><i class="fas fa-toggle-on fa-fw"></i></button>';
      }
    }

    $mydata = [++$count, $user->name, $user->email, '<span class="badge bg-success">'.ucfirst($user->role_name).'</span>', $user->team_name ?? '', empty($user->last_login_at)? 'Never' :\Carbon\Carbon::parse($user->last_login_at)->format('d F Y \a\t H:i') ?? 'Never loged in', '<nobr>'.$btn.'</nobr>'];
    $data[] = $mydata;
    
  }
  
  //dd($data);
  $config = [
    'data'=>$data,
    'responsive'=> true,
    'order' => [[1,'asc']],
    'columns' => [null, null, null, null, null, null, ['orderable' => false]],
  ]
@endphp
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header bg-lightblue">
        @permission('users-create')
          <button class="btn btn-sm bg-gradient-secondary" type="button" style="width: 98px" data-toggle="modal" data-target="#modal-userform"><i class="fas fa-plus fa-fw"></i> Add</button>
        @endpermission
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
        <x-adminlte-datatable id="usersTable" :heads="$heads" :config="$config" compressed/>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <x-modal title="Create User" id="modal-userform" type="" icon="fas fa-user-plus">
      <livewire:admin.users-form/>
  </x-modal>
  </div>
</div>
@stop

@section('footer')
  @include('includes.footer')
@stop

@section('js')
  <script type="text/javascript" src="{{asset('js/company.js')}}"></script>
@stop