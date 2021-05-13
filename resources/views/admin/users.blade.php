@extends('adminlte::page')

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
<div class="row">
  <div class="col-12">
    <livewire:admin.users/>
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
  
    $('#select2Role').select2();
    $('#select2Permission').select2();

    $('#select2Role').on('change', function(e){
      var data = $(this).select2("val");
      var formID = document.getElementById("userform");
      //console.log(formID);
      Livewire.find(formID.getAttribute('wire:id')).set('roles', data)
      //console.log(formID.getAttribute('wire:id'))
    });
    $('#select2Permission').on('change', function(e){
      var data = $(this).select2("val");
      var formID = document.getElementById("userform");
      //console.log(formID);
      Livewire.find(formID.getAttribute('wire:id')).set('permissions', data)
      //console.log(formID.getAttribute('wire:id'))
    });
  

  $("#modal-userform").on('hidden.bs.modal', function(){
      Livewire.emit('resetUserInputFields');
      $("#select2Role").val([]).trigger('change');
      $("#select2Permission").val([]).trigger('change');
    });

  document.addEventListener("livewire:load", () => {

    Livewire.hook('message.processed', (message, component) => {
      $('#select2Role').select2();
      $('#select2Permission').select2();
    }); 
  });
    
  window.addEventListener('closeUserModal', event => {
      $("#modal-userform").modal('hide');
  });

  window.addEventListener('openUserModal', event => {
    
    $.each(event.detail.roles, function (key, value) {
      $('#select2Role option[value='+value.id+']').prop('selected',true);
    });

    $.each(event.detail.permissions, function (key, value) {
      $('#select2Permission option[value='+value.id+']').prop('selected',true);
    });

    $('#select2Role').trigger('change');
    $('#select2Permission').trigger('change');

    $("#modal-userform").modal('show');
      
  });

  Livewire.on('alert', param => {
        toastr[param['type']](param['message']);
    });

  Livewire.on('triggerDeleteUser', userID => {
    Swal.fire({
      title: 'Are You Sure?',
      text: 'The user will be deleted!',
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Delete!'
      }).then((result) => {
		//if user clicks on delete
        if (result.value) {
		    // calling destroy method to delete
        Livewire.emit('deleteUser', userID);
        } 
      });
    }
  );

  Livewire.on('triggerInfoUser', user =>{
    var a = $("#modal-infoUser .modal-body").val();
    if(a===""){
      $("#modal-infoUser .modal-body").html(user);
    }else{
      console.log(a);
    }
    $("#modal-infoUser").modal('show');
  });
</script>
@stop