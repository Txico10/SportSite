@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Dashboard</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
@stop

@section('footer')
    <strong>Copyright &copy; 2016-2019 <a href="#">Torneio Bedjo</a>.</strong> All rights reserved.
@stop
