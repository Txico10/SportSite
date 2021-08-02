@extends('adminlte::page')
@section('title', 'Apartments')
@section('plugins.BootstrapSelect', true)
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Apartments List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              @permission('company-read')
              <li class="breadcrumb-item"><a href="{{route('company.profile', ['company'=>$company])}}">Company</a></li>
              @endpermission
              <li class="breadcrumb-item"><a href="{{route('company.buildings', ['company'=>$company])}}">Building</a></li>
              <li class="breadcrumb-item active">Apartments</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@stop

@section('content')
<div class="row">
  <div class="col-md-12">
    <livewire:management.apartment :company="$company"/>
  </div>
</div>
@stop

@section('footer')
  @include('includes.footer')
@stop

@section('js')
  <script type="text/javascript" src="{{asset('js/company.js')}}"></script>
  <script type="text/javascript">
    $('#myBuildings').selectpicker();
  </script>
@stop
