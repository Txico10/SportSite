$(function(){
  $('#legalform').select2({
    width: 'resolve'
  });
  $('#myBuildings').select2({
    width: 'resolve'
  });
  $('#apart_building').select2({
    width: 'resolve',
  });
  $('#apart_type').select2({
    width: 'resolve',
  });
  $('#employeeGender').select2({
    width: 'resolve',
  });
  $('#employeeCountry').select2({
    width: 'resolve',
  });
  $('#employee-city').select2({
    width: 'resolve',
  });
  
  $('#employee-role').select2({
    width: 'resolve',
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
      next: 'fas fa-caret-right',
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
  
  $("#modal-company").on('hidden.bs.modal', function(){
      Livewire.emit('resetCompanyInputFields');      
    }
  );
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
  
  $("#myBuildings").on('select2:select', function(event){
        var data = $(this).select2("val");
        var formID = document.getElementById("apartmentsList");
        Livewire.find(formID.getAttribute('wire:id')).set('buildingId', data);
        //console.log(data);
  });
  $("#apart_building").on('select2:select', function(event){
        var data = $(this).select2("val");
        var formID = document.getElementById("apartmentform");
        Livewire.find(formID.getAttribute('wire:id')).set('apart_building', data);
        //console.log(data);
  });
  $("#apart_type").on('select2:select', function(event){
        var data = $(this).select2("val");
        var formID = document.getElementById("apartmentform");
        Livewire.find(formID.getAttribute('wire:id')).set('apart_type', data);
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
  $('#employee-birthdate').on('hide.datetimepicker', function(e) {
    e.preventDefault();
    var birthdate = moment(e.date._d).format('YYYY-MM-DD');
    var mybdate = $(".datetimepicker-input").val();
    var formID = document.getElementById("myEmployeeForm");
    //console.log(birthdate);
    if(mybdate === '') {
      Livewire.find(formID.getAttribute('wire:id')).set('birthdate', null);
      $(".emp-birth").addClass('is-invalid').removeClass('is-valid');
      //console.log("birthdate = null");
    } else {
      mybdate = moment(mybdate, "DD MM YYYY").format('YYYY-MM-DD');
      if(birthdate !== mybdate){
        birthdate = mybdate;
      } 
      Livewire.find(formID.getAttribute('wire:id')).set('birthdate', birthdate);
      $(".emp-birth").addClass('is-valid').removeClass('is-invalid')
      //console.log(birthdate);
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
      console.log($(this).val());
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
  $("#showpasswd").on("click", function (event) {
    event.preventDefault;
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

});

document.addEventListener("livewire:load", () => {
    Livewire.hook('message.processed', (message, component) => {
        $('#myBuildings').select2({
          width: 'resolve'
        });
        
        $('#apart_building').select2({
          width: 'resolve',
        });

        $('#apart_type').select2({
          width: 'resolve',
        });

        $('#employeeGender').select2({
          width: 'resolve',
        });
    
        $('#employeeCountry').select2({
          width: 'resolve',
        });

        $('#employee-city').select2({
          width: 'resolve',
        });

        $('#employee-role').select2({
          width: 'resolve',
        });
      }); 
    }
);

window.addEventListener('openContactModal', event => {
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

  Livewire.on('alert', param => {
        toastr[param['type']](param['message']);
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

  Livewire.on('contactInfo', contact=>{
    $("#modal-showContact .modal-body").html(contact);
    $("#modal-showContact").modal('show');
    //console.log(data.html());
  });