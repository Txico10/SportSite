$(function(){

  /*------------------------
  |       Users Profile
  -------------------------*/
  
  /*
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
  */
});

/*------------------------
  |       Users Profile
  -------------------------*/
  

/*
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
    }).then((result) => {		//if user clicks on delete
      if (result.value) {		    // calling destroy method to delete
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
*/