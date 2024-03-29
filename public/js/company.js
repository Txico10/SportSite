$(function(){
  $('#user-role').select2({
    width: 'resolve',
    theme: 'bootstrap4',
  });

  $('#legalform').select2({
    width: 'resolve',
    theme: 'bootstrap4',
  });
  $('#contactCountry').select2({
    width: 'resolve',
    theme: 'bootstrap4',
  });
  $('#contactCity').select2({
    width: 'resolve',
    theme: 'bootstrap4',
  });

  $('#apart_building').select2({
    width: 'resolve',
    theme: 'bootstrap4',
  });
  $('#apart_type').select2({
    width: 'resolve',
    theme: 'bootstrap4',
  });
  $('#employeeGender').select2({
    width: 'resolve',
    theme: 'bootstrap4',
  });
  $('#employeeCountry').select2({
    width: 'resolve',
    theme: 'bootstrap4',
  });
  $('#employee-city').select2({
    width: 'resolve',
    theme: 'bootstrap4',
  });

  $('#employee-role').select2({
    width: 'resolve',
    theme: 'bootstrap4',
  });
  $('#editEmployeeGender').select2({
    width: 'resolve',
    theme: 'bootstrap4',
  });
  $('#furniture_list').select2({
    width: 'resolve',
    theme: 'bootstrap4',
  });
  $('#furniture_companyBuildings').select2({
    width: 'resolve',
    theme: 'bootstrap4',
  });
  $('#furniture_buildingApartments').select2({
    width: 'resolve',
    theme: 'bootstrap4',
  });


  $("#lot").inputmask({
    mask: "9 999 999",
    //placeholder: "*",
    showMaskOnHover: true,
    showMaskOnFocus: false,
    oncomplete: function(){
      var formID = document.getElementById("buildingform");
      //console.log($(this).val());
      Livewire.find(formID.getAttribute('wire:id')).set('lot', $(this).val());
      $(this).addClass('is-valid').removeClass('is-invalid');
    },
    onincomplete: function(){
      if($(this).val()===""){
        $(this).removeClass('is-invalid');
        $(this).removeClass('is-valid');
        //console.log("incomplete vide")
      } else {
        var formID = document.getElementById("buildingform");
        Livewire.find(formID.getAttribute('wire:id')).set('lot', null);
        $(this).addClass('is-invalid').removeClass('is-valid');
      }
    },
  });
  $("#employee-zip").inputmask({
    mask: "A9A9A9",
    placeholder: "*",
    showMaskOnHover: true,
    showMaskOnFocus: false,
    oncomplete: function(){
      var formID = document.getElementById("myEmployeeForm");
      //console.log($(this).val());
      Livewire.find(formID.getAttribute('wire:id')).set('zip', $(this).val());
      $(this).addClass('is-valid').removeClass('is-invalid');
    },
    onincomplete: function(){
      if($(this).val()===""){
        $(this).removeClass('is-invalid');
        $(this).removeClass('is-valid');
        //console.log("incomplete vide")
      } else {
        var formID = document.getElementById("myEmployeeForm");
        Livewire.find(formID.getAttribute('wire:id')).set('zip', null);
        $(this).addClass('is-invalid').removeClass('is-valid');
      }
    },
  });
  $('#employee-birthdate').datetimepicker({
    format: 'DD/MM/YYYY',
    useCurrent: false,
    icons: {
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right',
      today: 'fas fa-calendar-check',
      clear: 'fas fa-trash',
      close: 'fas fa-times-circle',
    },
    viewMode: 'days',
    toolbarPlacement: 'bottom',
    buttons: {
      showToday: true,
      showClear: true,
      showClose: true,
    },
    allowInputToggle:true,
  });

  $('#furniture-aquisition-date').datetimepicker({
    format: 'DD/MM/YYYY',
    useCurrent: false,
    icons: {
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right',
      today: 'fas fa-calendar-check',
      clear: 'fas fa-trash',
      close: 'fas fa-times-circle',
    },
    viewMode: 'days',
    toolbarPlacement: 'bottom',
    buttons: {
      showToday: true,
      showClear: true,
      showClose: true,
    },
    allowInputToggle:true,
  });

  $('#furnitute-assignement-date').datetimepicker({
    format: 'DD/MM/YYYY',
    useCurrent: false,
    icons: {
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right',
      today: 'fas fa-calendar-check',
      clear: 'fas fa-trash',
      close: 'fas fa-times-circle',
    },
    viewMode: 'days',
    toolbarPlacement: 'bottom',
    buttons: {
      showToday: true,
      showClear: true,
      showClose: true,
    },
    allowInputToggle:true,
  });

  $('#edit-employee-birthdate').datetimepicker({
    format: 'DD/MM/YYYY',
    useCurrent: false,
    icons: {
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right',
      today: 'fas fa-calendar-check',
      clear: 'fas fa-trash',
      close: 'fas fa-times-circle',
    },
    viewMode: 'days',
    toolbarPlacement: 'bottom',
    buttons: {
      showToday: true,
      showClear: true,
      showClose: true,
    },
    allowInputToggle:true,
  });

  $('#employee-startDate').datetimepicker({
    format: 'DD/MM/YYYY, HH:mm',
    useCurrent: true,
    sideBySide: true,
    icons: {
      time: 'far fa-clock',
      date: 'far fa-calendar',
      up: 'fas fa-arrow-up',
      down: 'fas fa-arrow-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right',
      today: 'far fa-calendar-check-o',
      clear: 'fas fa-trash',
      close: 'fas fa-times'
    },
    viewMode: 'days',
    toolbarPlacement: 'bottom',
    buttons: {
      showClear: true,
      showClose: true,
    },
    allowInputToggle:true,
  });
  $('#employee-startDate').on('hide.datetimepicker', function(e) {
    e.preventDefault();
    if(e.date!==null) {
      var startdate = moment(e.date._d).format('YYYY-MM-DD hh:mm:ss');
      var mysdate = $(".employee-start").val();
      var formID = document.getElementById("myEmployeeForm");
      //console.log("Form val: "+mysdate);
      if(mysdate === '') {
        Livewire.find(formID.getAttribute('wire:id')).set('startDate', null);
        $(".employee-start").addClass('is-invalid').removeClass('is-valid');
        //console.log("birthdate = null");
      } else {
        Livewire.find(formID.getAttribute('wire:id')).set('startDate', startdate);
        $(".employee-start").addClass('is-valid').removeClass('is-invalid')
        //console.log("Final value "+startdate);
      }
    } else {
      $(".employee-start").removeClass('is-valid')
    }
  });

  $('#employee-endDate').datetimepicker({
    format: 'DD/MM/YYYY, HH:mm',
    useCurrent: true,
    sideBySide: true,
    icons: {
      up: 'fas fa-arrow-up',
      down: 'fas fa-arrow-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right',
      clear: 'fas fa-trash',
      close: 'fas fa-times'
    },
    viewMode: 'days',
    toolbarPlacement: 'bottom',
    buttons: {
      showClear: true,
      showClose: true,
    },
    allowInputToggle:true,
  });

  $('#employee-endDate').on('hide.datetimepicker', function(e) {
    e.preventDefault();
    if(e.date!==null) {
      var end_date = moment(e.date._d).format('YYYY-MM-DD hh:mm:ss');
      var myedate = $(".employee-endDate").val();
      var formID = document.getElementById("myEmployeeForm");
      //console.log("Form val: "+end_date);
      if(myedate === '') {
        Livewire.find(formID.getAttribute('wire:id')).set('endDate', null);
        $(".employee-endDate").addClass('is-invalid').removeClass('is-valid');
        //console.log("end_date = null");
      } else {
        Livewire.find(formID.getAttribute('wire:id')).set('endDate', end_date);
        $(".employee-endDate").addClass('is-valid').removeClass('is-invalid')
        //console.log("Final value "+end_date);
      }
    } else {
      $(".employee-endDate").removeClass('is-valid')
    }
  });

  $("#tcontract").on('change', function(event){

    var formID = document.getElementById("myEmployeeForm");

    if(this.checked){
      $("#employee-endDate").hide();
      $(".employee-endDate").val("");
      //$('#employee-endDate').datetimepicker('clear');
      $(".employee-endDate").removeClass('is-valid')
      $(".employee-endDate").removeClass('is-invalid')
      Livewire.find(formID.getAttribute('wire:id')).set('tcontract', '1');
      //console.log("checked");
    }else{
      $("#employee-endDate").show();
      Livewire.find(formID.getAttribute('wire:id')).set('tcontract', '0');
      //console.log("unCheckd");
    }
  });

  $("#modal-profile").on('hidden.bs.modal', function(){
    Livewire.emit('resetProfileInputFields');

  });
  $("#modal-userform").on('hidden.bs.modal', function(){
    Livewire.emit('resetUserInputFields');
    //$("#select2Role").val([]).trigger('change');
    //$("#select2Permission").val([]).trigger('change');
  });
  $("#modal-company").on('hidden.bs.modal', function(){
      Livewire.emit('resetCompanyInputFields');
    }
  );
  $("#modal-user-roles-permissions").on('hidden.bs.modal', function(){
    //Livewire.emit('resetUserRPInputFields');
  });
  $("#modal-contact").on('hidden.bs.modal', function(){
      Livewire.emit('resetContactInputFiels');
    }
  );
  $("#modal-building").on('hidden.bs.modal', function(){
      $('#lot').val('');
      $('#lot').removeClass('is-valid');
      $('#lot').removeClass('is-invalid');
      //$('#lot').removeAttr("disabled");
      Livewire.emit('resetBuildingInputFields');
    }
  );
  $("#modal-apartment").on('hidden.bs.modal', function(){
      Livewire.emit('resetApartmentInputFiels');
    }
  );

  $("#modal-editEmployee").on('hidden.bs.modal', function(){
      Livewire.emit('resetEditEmployeeInputFields');
    }
  );

  $("#modal-furniture").on('hidden.bs.modal', function(){
    $('#furniture-aquisition-date').datetimepicker('clear');
    $(".furniture-aquisition-date").val("");
    $(".furniture-aquisition-date").removeClass('is-valid');
    $(".furniture-aquisition-date").removeClass('is-invalid');
    Livewire.emit('resetFurnitureInputFields');
  });

  $("#modal-furnitureAssignement").on('hidden.bs.modal', function(){
    $('#furnitute-assignement-date').datetimepicker('clear');
    $(".furnitute-assignement-date").val("");
    $(".furnitute-assignement-date").removeClass('is-valid');
    $(".furnitute-assignement-date").removeClass('is-invalid');
    Livewire.emit('resetFurnitureAssignementInputFields');
  });

  $("#user-role").on('select2:select', function(event){
    var data = $(this).select2("val");
    var formID = document.getElementById("userform");
    Livewire.find(formID.getAttribute('wire:id')).set('role', data);
    //console.log(data);
  });

  $("#employee-role").on('select2:select', function(event){
    var data = $(this).select2("val");
    var formID = document.getElementById("myEmployeeForm");
    Livewire.find(formID.getAttribute('wire:id')).set('role', data);
    //console.log(data);
  });
  $("#contactCountry").on('select2:select', function(event){
    var data = $(this).select2("val");
    var formID = document.getElementById("contact-form");
    Livewire.find(formID.getAttribute('wire:id')).set('country', data);
    //console.log(data);
  });
  $("#contactCity").on('select2:select', function(event){
    var data = $(this).select2("val");
    var formID = document.getElementById("contact-form");
    Livewire.find(formID.getAttribute('wire:id')).set('city', data);
    //console.log(data);
  });

  $("#apart_building").on('select2:select', function(event){
        var data = $(this).select2("val");
        var formID = document.getElementById("apartmentform");
        Livewire.find(formID.getAttribute('wire:id')).set('building_id', data);
        //console.log(data);
  });
  $("#apart_type").on('select2:select', function(event){
        var data = $(this).select2("val");
        var formID = document.getElementById("apartmentform");
        Livewire.find(formID.getAttribute('wire:id')).set('apartment_type_id', data);
        //console.log(data);
  });
  $("#employeeGender").on('select2:select', function(event){
    var data = $(this).select2("val");
    var formID = document.getElementById("myEmployeeForm");
    Livewire.find(formID.getAttribute('wire:id')).set('gender', data);
    //console.log(data);
  });
  $("#employeeCountry").on('select2:select', function(event){
    var data = $(this).select2("val");
    var formID = document.getElementById("myEmployeeForm");
    Livewire.find(formID.getAttribute('wire:id')).set('country', data);
    //console.log(data);
  });
  $("#employee-city").on('select2:select', function(event){
    var data = $(this).select2("val");
    var formID = document.getElementById("myEmployeeForm");
    Livewire.find(formID.getAttribute('wire:id')).set('city', data);
    //console.log(data);
  });
  $("#employee-role").on('select2:select', function(event){
    var data = $(this).select2("val");
    var formID = document.getElementById("myEmployeeForm");
    Livewire.find(formID.getAttribute('wire:id')).set('role', data);
    //console.log(data);
  });
  $("#editEmployeeGender").on('select2:select', function(event){
    var data = $(this).select2("val");
    var formID = document.getElementById("employee-edit-form");
    Livewire.find(formID.getAttribute('wire:id')).set('gender', data);
    //console.log(data);
  });
  $("#furniture_list").on('select2:select', function(event){
    var data = $(this).select2("val");
    var formID = document.getElementById("furniture-form");
    Livewire.find(formID.getAttribute('wire:id')).set('furniture_type_id', data);
    //console.log(data);
  });
  $("#furniture_companyBuildings").on('select2:select', function(event){
    var data = $(this).select2("val");
    var formID = document.getElementById("furnituteAssignForm");
    Livewire.find(formID.getAttribute('wire:id')).set('building_id', data);
    //console.log(data);
  });
  $("#furniture_buildingApartments").on('select2:select', function(event){
    var data = $(this).select2("val");
    var formID = document.getElementById("furnituteAssignForm");
    Livewire.find(formID.getAttribute('wire:id')).set('apartment_id', data);
    //console.log(data);
  });
  $('#employee-birthdate').on('hide.datetimepicker', function(e) {
    e.preventDefault();
    if(e.date!==null) {
      var birthdate = moment(e.date._d).format('YYYY-MM-DD');
      var mybdate = $(".employee-birthdate").val();
      var formID = document.getElementById("myEmployeeForm");
      //console.log(birthdate);
      if(mybdate === '') {
        Livewire.find(formID.getAttribute('wire:id')).set('birthdate', null);
        $(".employee-birthdate").addClass('is-invalid').removeClass('is-valid');
        //console.log("birthdate = null");
      } else {
        Livewire.find(formID.getAttribute('wire:id')).set('birthdate', birthdate);
        $(".employee-birthdate").addClass('is-valid').removeClass('is-invalid')
        //console.log(birthdate);
      }
    } else {
      $(".employee-birthdate").removeClass('is-valid')
    }
  });
  $('#edit-employee-birthdate').on('hide.datetimepicker', function(e) {
    e.preventDefault();
    if(e.date!==null) {
      var birthdate = moment(e.date._d).format('YYYY-MM-DD');
      var mybdate = $(".edit-employee-birth").val();
      var formID = document.getElementById("employee-edit-form");
      //console.log(birthdate);
      if(mybdate === '') {
        Livewire.find(formID.getAttribute('wire:id')).set('birthdate', null);
        $(".edit-employee-birth").addClass('is-invalid').removeClass('is-valid');
        //console.log("birthdate = null");
      } else {
        Livewire.find(formID.getAttribute('wire:id')).set('birthdate', birthdate);
        $(".edit-employee-birth").addClass('is-valid').removeClass('is-invalid')
        //console.log(birthdate);
      }
    } else {
      $(".edit-employee-birth").removeClass('is-valid')
    }
  });
  $('#furniture-aquisition-date').on('hide.datetimepicker', function(e) {
    e.preventDefault();
    if(e.date!==null) {
      var buydate = moment(e.date._d).format('YYYY-MM-DD');
      var mybuydate = $(".furniture-aquisition-date").val();
      var formID = document.getElementById("furniture-form");
      //console.log(birthdate);
      if(mybuydate === '') {
        Livewire.find(formID.getAttribute('wire:id')).set('buy_at', null);
        $(".furniture-aquisition-date").addClass('is-invalid').removeClass('is-valid');
        //console.log("birthdate = null");
      } else {
        Livewire.find(formID.getAttribute('wire:id')).set('buy_at', buydate);
        $(".furniture-aquisition-date").addClass('is-valid').removeClass('is-invalid')
        //console.log(birthdate);
      }
    } else {
      $(".furniture-aquisition-date").removeClass('is-valid')
      //console.log("NULL")
    }

  });

  $('#furnitute-assignement-date').on('hide.datetimepicker', function(e) {
    e.preventDefault();
    if(e.date!==null) {
      var assigndate = moment(e.date._d).format('YYYY-MM-DD');
      var myassigndate = $(".furnitute-assignement-date").val();
      var formID = document.getElementById("furnituteAssignForm");
      //console.log(birthdate);
      if(myassigndate === '') {
        Livewire.find(formID.getAttribute('wire:id')).set('assigned_at', null);
        $(".furnitute-assignement-date").addClass('is-invalid').removeClass('is-valid');
        //console.log("birthdate = null");
      } else {
        Livewire.find(formID.getAttribute('wire:id')).set('assigned_at', assigndate);
        $(".furnitute-assignement-date").addClass('is-valid').removeClass('is-invalid')
        //console.log(birthdate);
      }
    } else {
      $(".furnitute-assignement-date").removeClass('is-valid')
      //console.log("NULL")
    }

  });

  $("#modal-employee").on('hidden.bs.modal', function(){
    //console.log("Hello");
    $('#employee-birthdate').datetimepicker('clear');
    $(".employee-birth").val("");
    $(".employee-birth").removeClass('is-valid');
    $(".employee-birth").removeClass('is-invalid');

    $("#employee-zip").val('');
    $("#employee-zip").addClass('').removeClass('is-valid');

    $("#employee-mobile").val("");
    $("#employee-mobile").removeClass('is-valid');

    $(".employee-start").val("");
    //$("#employee-startDate").datetimepicker('clear');
    $(".employee-start").removeClass('is-valid')
    $(".employee-start").removeClass('is-invalid');

    $("#employee-endDate").hide();
    $(".employee-endDate").val("");
    //$('#employee-endDate').datetimepicker('clear');
    $(".employee-endDate").removeClass('is-valid');
    $(".employee-endDate").removeClass('is-invalid');
    //console.log('END');
    Livewire.emit('resetEmployeeInputFields');
    }
  );

  $("#employee-mobile").inputmask({
    mask: "(999) 999-9999",
    tabThrough:true,
    clearIncomplete: true,
    oncomplete: function(){
      var formID = document.getElementById("myEmployeeForm");
      //console.log($(this).val());
      Livewire.find(formID.getAttribute('wire:id')).set('mobile', $(this).val());
      $(this).addClass('is-valid').removeClass('is-invalid');
    },
    onincomplete: function() {
      if($(this).val()==="") {
        $(this).removeClass('is-invalid');
        $(this).removeClass('is-valid');
      } else {
        var formID = document.getElementById("myEmployeeForm");
        Livewire.find(formID.getAttribute('wire:id')).set('mobile', null);
        $(this).addClass('is-invalid').removeClass('is-valid');
      }
    },
  });

  $("#contactTelephone").inputmask({
    mask: "(999) 999-9999",
    tabThrough:true,
    clearIncomplete: true,
    oncomplete: function(){
      var formID = document.getElementById("contact-form");
      //console.log($(this).val());
      Livewire.find(formID.getAttribute('wire:id')).set('telephone', $(this).val());
      $(this).addClass('is-valid').removeClass('is-invalid');
    },
    onincomplete: function() {
      if($(this).val()==="") {
        $(this).removeClass('is-invalid');
        $(this).removeClass('is-valid');
      } else {
        var formID = document.getElementById("contact-form");
        Livewire.find(formID.getAttribute('wire:id')).set('telephone', null);
        $(this).addClass('is-invalid').removeClass('is-valid');
      }
    },
  });

  $("#contactMobile").inputmask({
    mask: "(999) 999-9999",
    tabThrough:true,
    clearIncomplete: true,
    oncomplete: function(){
      var formID = document.getElementById("contact-form");
      //console.log($(this).val());
      Livewire.find(formID.getAttribute('wire:id')).set('mobile', $(this).val());
      $(this).addClass('is-valid').removeClass('is-invalid');
    },
    onincomplete: function() {
      if($(this).val()==="") {
        $(this).removeClass('is-invalid');
        $(this).removeClass('is-valid');
      } else {
        var formID = document.getElementById("contact-form");
        Livewire.find(formID.getAttribute('wire:id')).set('mobile', null);
        $(this).addClass('is-invalid').removeClass('is-valid');
      }
    },
  });

  $("#editProfileButton").on('click', function(){
    Livewire.emit('editProfile');
  });

  $("#showpasswd").on("click", function (event) {
    event.preventDefault();
    var password = $("#password").val();
    //console.log($(".text-info").text());
    if($(".passwd-txt").text()==="*********") {
      $(".passwd-txt").text(password);
      $('.toggle-password').addClass('fa-eye-slash').removeClass('fa-eye');
      //console.log("IN")
    } else {
      $(".passwd-txt").text("*********");
      $('.toggle-password').addClass('fa-eye').removeClass('fa-eye-slash');
      //console.log("OUT");
    }
  });

  $("#DeleteAssignFurniture").on("click", function(event){
        var assign = $(this).val()
        //console.log(assign);
        Swal.fire({
            title: 'Are You Sure?',
            text: 'The furnuture assignement will be deleted!',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete!'
        }).then((result) => {
                //if user clicks on delete
            if (result.value) {
                    // calling destroy method to delete
                Livewire.emit('deleteFurnitureAssign', assign);
                //console.log(assign);

            }
        });
    });
  $(".editFurnitureButton").on("click", function(){
    var furnitureID = $(this).val();
    Livewire.emit('editFurniture', furnitureID);
  });

});

document.addEventListener("livewire:load", () => {
    Livewire.hook('message.processed', (message, component) => {
      $('#user-role').select2({
        width: 'resolve',
        theme: 'bootstrap4',
      });

      $('#legalform').select2({
        width: 'resolve',
        theme: 'bootstrap4',
      });

      $('#contactCountry').select2({
        width: 'resolve',
        theme: 'bootstrap4',
      });
      $('#contactCity').select2({
        width: 'resolve',
        theme: 'bootstrap4',
      });
      $('#apart_building').select2({
        width: 'resolve',
        theme: 'bootstrap4',
      });
      $('#apart_type').select2({
        width: 'resolve',
        theme: 'bootstrap4',
      });
      $('#employeeGender').select2({
        width: 'resolve',
        theme: 'bootstrap4',
      });

      $('#employeeCountry').select2({
        width: 'resolve',
        theme: 'bootstrap4',
      });
      $('#employee-city').select2({
        width: 'resolve',
        theme: 'bootstrap4',
      });
      $('#employee-role').select2({
        width: 'resolve',
        theme: 'bootstrap4',
      });
      $('#editEmployeeGender').select2({
        width: 'resolve',
        theme: 'bootstrap4',
      });
      $('#furniture_list').select2({
        width: 'resolve',
        theme: 'bootstrap4',
      });
      $('#furniture_companyBuildings').select2({
        width: 'resolve',
        theme: 'bootstrap4',
      });
      $('#furniture_buildingApartments').select2({
        width: 'resolve',
        theme: 'bootstrap4',
      });

    });
  }
);

  Livewire.on('alert', param => {
    toastr[param['type']](param['message']);
  });

  Livewire.on('newUserSpeciaCreate', param => {
    toastr.options.onHidden = function() { location.reload() }
    toastr[param['type']](param['message']);
  });

window.addEventListener('closeUserModal', event => {
  $("#modal-userform").modal('hide');
});

window.addEventListener('openModalProfile', event => {
  $("#modal-profile").modal('show');
});

window.addEventListener('closeModalProfile', event => {
  $("#modal-profile").modal('hide');
});

window.addEventListener('openContactModal', event => {
      //console.log(event);
      if(event.detail.telephone!==null){
        $('#contactTelephone').val(event.detail.telephone)
        $('#contactTelephone').addClass('is-valid')
      }else {
        $('#contactTelephone').val("")
        $('#contactTelephone').removeClass('is-valid')
      }
      if(event.detail.mobile!==null){
        $('#contactMobile').val(event.detail.mobile)
        $('#contactMobile').addClass('is-valid')
      }else {
        $('#contactMobile').val("")
        $('#contactMobile').removeClass('is-valid')
      }
      $("#modal-contact").modal('show');
    }
);

  window.addEventListener('closeContactModal', event => {
      $("#modal-contact").modal('hide');
    }
  );

  window.addEventListener('closeCompanyModal', event => {
      $("#modal-company").modal('hide');
    }
  );

  window.addEventListener('openCompanyModal', event => {
      $("#modal-company").modal('show');
    }
  );

  window.addEventListener('openBuildingModal', event => {
      $('#lot').val(event.detail.lot);
      $('#lot').addClass('is-valid');
      //$('#lot').attr('disabled', 'disabled');
      $("#modal-building").modal('show');
    }
  );

  window.addEventListener('closeBuildingModal', event => {
      $("#modal-building").modal('hide');
    }
  );

  window.addEventListener('openApartmentModal', event => {
      $("#modal-apartment").modal('show');
    }
  );

  window.addEventListener('closeApartmentModal', event => {
      $("#modal-apartment").modal('hide');
    }
  );

  window.addEventListener('openShowContactModal', event => {
    $("#modal-showContact").modal('show');
  });

  window.addEventListener('closeShowContactModal', event => {
    $("#modal-showContact").modal('hide');
  });

  window.addEventListener('closeEmployeeModal', event => {
    $("#modal-employee").modal('hide');
  });

  window.addEventListener('openEmployeeEditModal', event => {
    //console.log(event.detail.birthdate)
    $(".edit-employee-birth").val(event.detail.birthdate)
    $(".edit-employee-birth").addClass('is-valid').removeClass('is-invalid');
    $("#modal-editEmployee").modal('show');
  });

  window.addEventListener('closeEmployeeEditModal', event => {
    //console.log("YES")
    $("#modal-editEmployee").modal('hide');
  });

  window.addEventListener('openFurnitureModal', event => {
    $(".furniture-aquisition-date").val(event.detail.buy_at);
    $(".furniture-aquisition-date").addClass('is-valid').removeClass('is-invalid');
    $("#modal-furniture").modal('show');
  });

  window.addEventListener('closeFurnitureModal', event => {
    $("#modal-furniture").modal('hide');
  });

  window.addEventListener('closeFurnitureAssignementModal', event => {
    $("#modal-furnitureAssignement").modal('hide');
  });

  Livewire.on('contactInfo', contact=>{
    $("#modal-showContact .modal-body").html(contact);
    $("#modal-showContact").modal('show');
  });

  $("#DeleteAssignFurniture").click(function(){
    console.log("Hello");
  });

