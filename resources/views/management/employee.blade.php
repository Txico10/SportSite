@extends('adminlte::page')
@section('title', 'Employees')
@section('plugins.Datatables', true)
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Employees List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              @permission('company-read')
              <li class="breadcrumb-item"><a href="{{route('company.profile', ['company'=>$company])}}">Company</a></li>
              @endpermission
              <li class="breadcrumb-item active">Employees</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@stop

@section('content')
@php
    $heads = [
        '#',
        'Name',
        'Birthdate',
        'NAS',
        'Gender',
        'Role',
        'Action',
    ];

    $config = [
        'processing' => true,
        'serverSide' => true,
        'ajax' => ['headers'=> ['X-CSRF-TOKEN'=>csrf_token()], 'url'=> route('company.employees', ['company'=>$company])],
        'responsive'=> true,
        'order' => [[1,'asc']],
        'columns' => [['data'=>'DT_RowIndex'], ['data'=>'name'], ['data'=>'birthdate'], ['data'=>'nas'], ['data'=>'gender'], ['data'=>'role_name'], [ 'data'=>'action', 'searchable'=>false, 'orderable' => false]],
    ]
@endphp
<!-- Default box -->
<div class="card card-lightblue card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <a type="button" class="btn btn-tool" href="{{route('company.employees.create', ['company'=>$company])}}">
                <i class="fas fa-fw fa-plus-square"></i>
            </a>
            New Employee
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <x-adminlte-datatable id="employeesTable" :heads="$heads" :config="$config"/>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
@stop

@section('footer')
  @include('includes.footer')
@stop

@section('js')
  <script type="text/javascript" src="{{asset('js/company.js')}}"></script>
@stop
