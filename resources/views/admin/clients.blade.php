@extends('adminlte::page')

@section('title', 'Clients')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Clients List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Clients</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@stop

@section('content')
<div class="row">
  <div class="col-6">
    <livewire:admin.clients />
  </div>
  <div class="col-6">

  </div>
</div>
@stop

@section('footer')
  @include('includes.footer')
@stop

@section('js')
<script>
  $(function() {
    $('#legalform').select2();
    $('#managerGender').select2();
    $('#country').select2();
    $('#city').select2();

    $('#neq').inputmask({
      mask:"999999999",
      placeholder:"*",
      oncomplete: function(){
        var formID = document.getElementById("myclient-form");
        //console.log($(this).val());
        Livewire.find(formID.getAttribute('wire:id')).set('neq', $(this).val());
        $(this).addClass('is-valid').removeClass('is-invalid');
      },
      onincomplete: function(){
        if($(this).val()===""){
          $(this).removeClass('is-invalid');
          $(this).removeClass('is-valid');
          //console.log("incomplete vide")
        } else {
          var formID = document.getElementById("myclient-form");
          Livewire.find(formID.getAttribute('wire:id')).set('neq', null);
          $(this).addClass('is-invalid').removeClass('is-valid');
        }        
      },

    });


    $('#managerBirth').datetimepicker({
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

    //$(".myBirth").inputmask(undefined,{
    //  oncomplete: function () {
    //    console.log("Manager Birth date")
    //  },
    //});

    $('#managerBirth').on('hide.datetimepicker', function(e) {
      e.preventDefault();
      if(e.date!==null) {
        var birthdate = moment(e.date._d).format('YYYY-MM-DD');
        var mybdate = $(".managerBirth").val();
        var formID = document.getElementById("myclient-form");
        //console.log(birthdate);
        if(mybdate === '') {
          Livewire.find(formID.getAttribute('wire:id')).set('managerBirth', null);
          $(".managerBirth").addClass('is-invalid').removeClass('is-valid');
          //console.log("birthdate = null");
        } else {
          mybdate = moment(mybdate, "DD MM YYYY").format('YYYY-MM-DD'); 
          Livewire.find(formID.getAttribute('wire:id')).set('managerBirth', birthdate);
          $(".managerBirth").addClass('is-valid').removeClass('is-invalid')
          //console.log(birthdate);
        }
      } else {
        $(".managerBirth").removeClass('is-valid')
      }
      
    });

    $("#zip").inputmask({
      mask: "A9A9A9",
      placeholder: "*",
      showMaskOnHover: true,
      showMaskOnFocus: false,
      oncomplete: function(){
        var formID = document.getElementById("myclient-form");
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
          var formID = document.getElementById("myclient-form");
          Livewire.find(formID.getAttribute('wire:id')).set('zip', null);
          $(this).addClass('is-invalid').removeClass('is-valid');
        }
      },
    });  

    $("#managerMobile").inputmask({
      mask: "(999) 999-9999",
      tabThrough:true,
      clearIncomplete: true,
      oncomplete: function(){
        var formID = document.getElementById("myclient-form");
        //console.log($(this).val());
        Livewire.find(formID.getAttribute('wire:id')).set('managerMobile', $(this).val());
        $(this).addClass('is-valid').removeClass('is-invalid');
      },
      onincomplete: function() {
        if($(this).val()==="") {
          $(this).removeClass('is-invalid');
          $(this).removeClass('is-valid');
        } else {
          var formID = document.getElementById("myclient-form");
          Livewire.find(formID.getAttribute('wire:id')).set('managerMobile', null);
          $(this).addClass('is-invalid').removeClass('is-valid');
        } 
      },
    });
    
    $("#modal-createcompany").on('hidden.bs.modal', function(){
        Livewire.emit('resetNewCompanyInputFields');
        $("#neq").val("").trigger('change');
        $("#neq").removeClass('is-valid');
        $("#country").val("").trigger('change');
        $('#zip').val("").trigger('change');
        $("#zip").removeClass('is-valid');
        $('#managerBirth').datetimepicker('clear');
        $(".managerBirth").addClass('').removeClass('is-valid');
        $(".managerBirth").addClass('').removeClass('is-invalid');
        $("#managerMobile").val("").trigger('change');
        $("#managerMobile").removeClass('is-valid');
      }
    );

    window.addEventListener('closeClientModal', event => {
      $("#modal-createcompany").modal('hide');
    });

  });

  document.addEventListener("livewire:load", () => {
      Livewire.hook('message.processed', (message, component) => {
        $('#legalform').select2();
        $('#country').select2();
        $('#city').select2();
        $('#managerGender').select2();
      });

    });

  $("#legalform").on('select2:select', function(event){
          var data = $(this).select2("val");
          var formID = document.getElementById("myclient-form");
          Livewire.find(formID.getAttribute('wire:id')).set('legalform', data);
    }
  );

  $("#country").on('select2:select', function(event){
          var data = $(this).select2("val");
          var formID = document.getElementById("myclient-form");
          Livewire.find(formID.getAttribute('wire:id')).set('country', data);
          //console.log(data);
          //CAN, USA, GBR
    }
  );

  $("#city").on('select2:select', function(event){
          var data = $(this).select2("val");
          var formID = document.getElementById("myclient-form");
          Livewire.find(formID.getAttribute('wire:id')).set('city', data);
          //console.log(data);
          //CAN, USA, GBR
    }
  );
  $("#city").on("select2:unselect", function(event){
    $("#region").removeClass('is-valid');
    console.log("City change");
    // var data = $(this).select2("val");
    var formID = document.getElementById("myclient-form");
    Livewire.find(formID.getAttribute('wire:id')).set('city', null);
    //Livewire.find(formID.getAttribute('wire:id')).set('region', null);
          //console.log(data);
          //CAN, USA, GBR
    }
  );
  
  $("#managerGender").on('select2:select', function(event){
          var data = $(this).select2("val");
          var formID = document.getElementById("myclient-form");
          Livewire.find(formID.getAttribute('wire:id')).set('managerGender', data);
          //console.log(data);
    }
  );

  Livewire.on('alert', param => {
        toastr[param['type']](param['message']);
    });

  $("#showpasswd").on("click", function (event) {
    event.preventDefault;
    var password = $("#managerPassword").val();
    if($(".text-info").text()==="*********") {
      $(".text-info").text(password);
      $('.toggle-password').addClass('fa-eye-slash').removeClass('fa-eye');
    } else {
      $(".text-info").text("*********");
      $('.toggle-password').addClass('fa-eye').removeClass('fa-eye-slash');
    }
  })

</script>

@stop