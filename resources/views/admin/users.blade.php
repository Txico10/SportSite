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

  $config = [
    'processing' => true,
    'serverSide' => true,
    'ajax' => ['headers'=> ['X-CSRF-TOKEN'=>csrf_token()], 'url'=> route('admin.users')],
    //'data'=>$data,
    'responsive'=> true,
    'order' => [[1,'asc']],
    'columns' => [['data'=>'DT_RowIndex'], ['data'=>'name'], ['data'=>'email'], ['data'=>'role_name'], ['data'=>'team_name'], ['data'=>'last_login_at'], [ 'data'=>'action', 'searchable'=>false, 'orderable' => false]],
  ]
@endphp
<div class="row">
  <div class="col-md-12">
    <div class="card card-lightblue card-outline">
      <div class="card-header">
        @permission('users-create')
          <button class="btn btn-sm btn-outline-primary shadow" type="button" style="width: 98px" data-toggle="modal" data-target="#modal-userform"><i class="fas fa-plus fa-fw"></i> Add</button>
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
    @if(Auth::user()->hasRole('superadministrator'))
    <x-modal title="Create User" id="modal-userform" type="" icon="fas fa-user-plus">
      <livewire:admin.users-form/>
  </x-modal>
  @endif
  </div>
</div>
@stop

@section('footer')
  @include('includes.footer')
@stop

@section('js')
  <script type="text/javascript" src="{{asset('js/company.js')}}"></script>
    <script type="text/javascript">
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#usersTable").on("click", ".userDelete", function(event){
                event.preventDefault();
                var userID = $(this).val();
                //console.log(userID);
                let _url='users/'+userID
                Swal.fire({
                    title: 'The user will be permanently deleted!!!',
                    text: 'If you are not sure please click on cancel',
                    type: "error",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Delete!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url:_url,
                            type: "DELETE",
                            cache: false,
                            data: {
                                user_id: userID,
                            },
                            success: function(response) {
                                $("#usersTable").DataTable().ajax.reload();
                                toastr[response.type](response.message);
                            },
                            error: function(response){
                                $.each(response.responseJSON.message, function(key, value){
                                    toastr.error(value)
                                    //toastr["error"](value);
                                })
                            }
                        });
                    }
                });
            });

            $("#usersTable").on("click", ".changeStatus", function(event){
                event.preventDefault();
                var userID = $(this).val();
                //console.log(userID);
                let _url='users/'+userID+'/changeStatus'
                Swal.fire({
                    title: 'Are You Sure?',
                    text: 'The user status will be changed!!!',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Save!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url:_url,
                            type: "PATCH",
                            cache: false,
                            data: {
                                user_id: userID,
                            },
                            success: function(response) {
                                $("#usersTable").DataTable().ajax.reload();
                                toastr.success(response.message);
                            },
                            error: function(response){
                                $.each(response.responseJSON.errors, function(key, value){
                                    toastr.error(value)
                                    //toastr["error"](value);
                                })
                            }
                        });
                    }
                });
            });
        })
    </script>
@stop
