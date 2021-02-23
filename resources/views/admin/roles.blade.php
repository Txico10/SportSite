@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
    <h1></h1>
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Roles and permissions</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Roles</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@stop

@section('content')
<div class="row">
  <div class="col-md-2">
    <!-- To be fixed-->
  </div>
  <div class="col-md-8">
    <div class="card card-primary card-outline card-outline-tabs">
      <div class="card-header p-0 border-bottom-0">
        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Roles</a>
          </li>
          @permission('permissions-read')
          <li class="nav-item">
            <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Permissions</a>
          </li>
          @endpermission
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content" id="custom-tabs-four-tabContent">
          <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
            <livewire:admin.roles/>
          </div>
          @permission('permissions-read')
          <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
            <livewire:admin.permissions/>
          </div>
          @endpermission
        </div>
      </div>
      <!-- /.card -->
    </div>
  </div>
  <div class="col-md-2">
    <!-- To be fixed-->
  </div>
</div>
@stop

@section('footer')
  <div class="float-right d-none d-sm-block">
    <b>Version</b> {{app()->version()}}
  </div>
    <strong>Copyright &copy; 2018-2020 <a href="#">SMConsulting</a>.</strong> All rights reserved.
@stop

@section('js')
<script>

  $(document).ready(function(){
    $("#modal-roles").on('hidden.bs.modal', function(){
      Livewire.emit('resetRoleInputFields');
      $("#select2bs4").val([]).trigger('change');
    });
    
    $("#modal-permissions").on('hidden.bs.modal', function(){
      Livewire.emit('resetPermissionsInputFields');
    });
    
    $('#select2bs4').select2();

    $('#select2bs4').on('change', function(e){
      var data = $(this).select2("val")
      var formID = document.getElementById("roleform")
      Livewire.find(formID.getAttribute('wire:id')).set('permissions', data)
      //console.log(formID.getAttribute('wire:id'))
    });
  });

  document.addEventListener("livewire:load", () => {
	  Livewire.hook('message.processed', (message, component) => {
		  $('#select2bs4').select2();
	  }); 
  });

  window.addEventListener('closeRoleModal', event => {
      $("#modal-roles").modal('hide');
  });

  window.addEventListener('openRoleModal', event => {
    //console.log(event.detail.permissions);
    $.each(event.detail.permissions, function (key, value) {
      $('#select2bs4 option[value='+value.id+']').prop('selected',true);
      //alert(value.id + ":" + value.name)
    });
    $('#select2bs4').trigger('change');
    //console.log(event.detail.permissions)
    $("#modal-roles").modal('show');
      
  });

  window.addEventListener('closePermissionModal', event => {
      $("#modal-permissions").modal('hide');
  });

  window.addEventListener('openPermissionModal', event => {
      $("#modal-permissions").modal('show');
  });

  Livewire.on('alert', param => {
        toastr[param['type']](param['message']);
  });

  Livewire.on('modal-roleInfo', role =>{
    var a = $("#modal-rolePerms .modal-body").val();
    if(a===""){
      $("#modal-rolePerms .modal-body").html(role);
    }else{
      console.log(a);
    }
    $("#modal-rolePerms").modal('show');
  });

  Livewire.on('modal-permissionInfo', permission =>{
    var a = $("#modal-permissionInfo .modal-body").val();
    if(a===""){
      $("#modal-permissionInfo .modal-body").html(permission);
    }else{
      console.log(a);
    }
    $("#modal-permissionInfo").modal('show');
  });

  Livewire.on('triggerDeleteRole', roleID => {
    Swal.fire({
      title: 'Are You Sure?',
      text: 'The role will be deleted!',
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Delete!'
      }).then((result) => {
		//if user clicks on delete
        if (result.value) {
		    // calling destroy method to delete
        Livewire.emit('deleteRole', roleID);

        } 
      });
    }
  );

  Livewire.on('triggerDeletePermision', permissionID => {
    Swal.fire({
      title: 'Are You Sure?',
      text: 'The Permission will be deleted!',
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Delete!'
      }).then((result) => {
		//if user clicks on delete
        if (result.value) {
		    // calling destroy method to delete
        Livewire.emit('deletePermission', permissionID);

        } 
      });
    });

    
</script>
  
  
@stop