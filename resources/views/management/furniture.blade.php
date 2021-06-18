@extends('adminlte::page')
@section('title', 'Furnitures')
@section('plugins.BootstrapSelect', true)
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Furnitures List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item active">Furnitures</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@stop

@section('content')
  <livewire:management.furnitures :company="$company" />
@stop

@section('footer')
  @include('includes.footer')
@stop

@section('js')
  <script type="text/javascript" src="{{asset('js/company.js')}}"></script>
@stop