@extends('adminlte::page')
@section('title', 'Buildings')
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Buildings List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              @permission('company-read')
              <li class="breadcrumb-item"><a href="{{route('company.profile', ['company'=>$company])}}">Company</a></li>
              @endpermission
              <li class="breadcrumb-item active">Building</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@stop

@section('content')
<div class="row">
  <div class="col-md-12">
    <livewire:management.buildings :company="$company"/>
  </div>
</div>
@stop

@section('footer')
  @include('includes.footer')
@stop

@section('js')
  <script type="text/javascript" src="{{asset('js/company.js')}}"></script>
@stop
