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
    <livewire:management.company :company="$company->id" />
    <livewire:management.contact :company="$company->id" />
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
                <livewire:management.buildings :company="$company->id"/>
              </div>
            </div>
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="apartments">
            <div class="row">
              <div class="col-md-12">
                <livewire:management.apartment :company="$company->id"/>
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
    $('#legalform').select2();
    $('#myBuildings').select2();
    $("#modal-company").on('hidden.bs.modal', function(){
        Livewire.emit('resetCompanyInputFields');      
      }
    );
    $("#myBuildings").on('select2:select', function(event){
          var data = $(this).select2("val");
          var formID = document.getElementById("apartmentsList");
          Livewire.find(formID.getAttribute('wire:id')).set('building_id', data);
          //console.log(data);
    });

  });

  document.addEventListener("livewire:load", () => {
      Livewire.hook('message.processed', (message, component) => {
        $('#myBuildings').select2();
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

  Livewire.on('alert', param => {
        toastr[param['type']](param['message']);
    }
  );
</script>
  
@stop