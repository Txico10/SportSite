@extends('adminlte::page')

@section('title', 'Apartments')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Apartments List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{route('company.buildings', ['id'=>$id])}}">Building</a></li>
              <li class="breadcrumb-item active">Apartments</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@stop

@section('content')
<div class="row">
  <div class="col-md-12">
    <livewire:management.apartment :company="$id"/>
  </div>
</div>
@stop

@section('footer')
  @include('includes.footer')
@stop

@section('js')
<script>
    $(document).ready(function(){
    
        $('#myBuildings').select2();
    
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
    });
</script>

@stop