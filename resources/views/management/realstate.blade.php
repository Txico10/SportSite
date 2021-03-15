@extends('adminlte::page')

@section('title', 'Company profile')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">My company</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item active">Real Estate</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@stop

@section('content')
<div class="row">
  <div class="col-md-3">
    <livewire:management.company :company="$company" />
    <livewire:management.contact :company="$company" />
  </div>
  <div class="col-md-9">
    <div class="card">
      <div class="card-header d-flex p-0">
        <h3 class="card-title p-3">Tabs</h3>
        <ul class="nav nav-pills ml-auto p-2">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
              Dropdown <span class="caret"></span>
            </a>
            <div class="dropdown-menu">
              <a class="dropdown-item" tabindex="-1" href="#">Buildings</a>
              <a class="dropdown-item" tabindex="-1" href="#">Apartments</a>
              <a class="dropdown-item" tabindex="-1" href="#">Something else</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" tabindex="-1" href="#">Separated link</a>
            </div>
          </li>
          <li class="nav-item"><a class="nav-link active" href="#buildings" data-toggle="tab">Buildings</a></li>
          <li class="nav-item"><a class="nav-link" href="#apartments" data-toggle="tab">Apartments</a></li>
          <li class="nav-item"><a class="nav-link" href="#employees" data-toggle="tab">Employees</a></li>
          <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Tab 3</a></li>
        </ul>
      </div><!-- /.card-header -->
      <div class="card-body">
        <div class="tab-content">
          <div class="tab-pane active" id="buildings">
            <div class="row">
              <div class="col-md-12">
                <livewire:management.buildings :company="$company"/>
              </div>
            </div>
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="apartments">
            <div class="row">
              <div class="col-md-12">
                <livewire:management.apartment :company="$company"/>
              </div>
            </div>
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="employees">
            <livewire:management.employees :company_id="$company->id"/>
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="tab_3">
            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
            when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            It has survived not only five centuries, but also the leap into electronic typesetting,
            remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
            sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
            like Aldus PageMaker including versions of Lorem Ipsum.
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div><!-- /.card-body -->
    </div>
  </div>
</div>
@stop

@section('footer')
  @include('includes.footer')
@stop

@section('js')
<script>

  $(document).ready(function(){
    $('#legalform').select2({
      theme: 'bootstrap4',
      width: 'resolve'
    });
    $('#myBuildings').select2({
      theme: 'bootstrap4',
      width: 'resolve'
    });

    $('#apart_building').select2({
      width: 'resolve',
    });

    $('#apart_type').select2({
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

  });

  document.addEventListener("livewire:load", () => {
      Livewire.hook('message.processed', (message, component) => {
        $('#myBuildings').select2({
          theme: 'bootstrap4',
          width: 'resolve'
        });
        
        $('#apart_building').select2({
          width: 'resolve',
        });

        $('#apart_type').select2({
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

</script>
  
@stop