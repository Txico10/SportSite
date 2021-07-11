@extends('adminlte::page')
@section('plugins.BootstrapSelect', true)
@section('plugins.Datatables', true)
@section('title', 'Furnitures')
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
@php
  $heads = [
    'Code',
    'Type',
    'Manufacturer',
    'Model',
    'Serial',
    'Aquired',
    'Status',
    'Action',
  ];

  $data = array();
  $btn = null;
  foreach ($furnitures as $key => $furniture) {
    $btn = '<a class="btn btn-outline-primary btn-sm mx-1 shadow" type="button" title="Furniture info" href="'.route('company.furnitures.show', ['id'=>$company->id, 'furniture'=>$furniture]).'"><i class="fas fa-info-circle fa-fw"></i></a>';
    
    if(empty($furniture->salvage_at)) {
      $active="Active";
      if(Auth::user()->isAbleTo('furniture-update')){
        $btn = $btn.'<button class="btn btn-outline-secondary mx-1 shadow btn-sm editFurnitureButton" type="button" title="Edit furniture" value="'.$furniture->id.'"><i class="fas fa-pencil-alt fa-fw"></i></button>';
        $btn = $btn.'<button class="btn btn-outline-success mx-1 shadow btn-sm salvageFurnitureButton" type="button" title="Send to trash" data-company="'.$company->id.'" value="'.$furniture->id.'"><i class="fas fa-archive fa-fw"></i></button>';
      }  
      if(Auth::user()->isAbleTo('furniture-delete')){
        $btn = $btn.'<button class="btn btn-outline-danger mx-1 shadow btn-sm deleteFurnitureButton" title="Delete Furniture" type="button" data-company="'.$company->id.'" value="'.$furniture->id.'"><i class="fas fa-trash-alt fa-fw"></i></button>';
      }
    } else{
      $active = "Discontinued";
    }

    $mydata = [$furniture->code, ucfirst($furniture->furnitureType->description), ucfirst($furniture->manufacturer), strtoupper($furniture->model), strtoupper($furniture->serial), \Carbon\Carbon::parse($furniture->buy_at)->format('d F Y'), $active, '<nobr>'.$btn.'</nobr>'];
    array_push($data, $mydata);
  }
  //dd($furniture->furnitureAssigned()->apartment_id);
  $config = [
    'data'=>$data,
    'responsive'=> true,
    'order' => [[0,'asc']],
    'columns' => [null, null, null, null, null, null, null, ['orderable' => false]],
  ]
@endphp
  <!-- Default box -->
  @if(session('status'))
    <x-adminlte-alert theme="success" title="Success" dismissable>
      {{session('status')}}
    </x-adminlte-alert>
  @endif
  <div class="card">
    <div class="card-header">
      @permission('furniture-create')
        <button class="btn btn-sm btn-outline-primary" type="button" data-toggle="modal" data-target="#modal-furniture" style="width: 98px"><i class="fas fa-plus"></i> Add</button>
      @endpermission
    </div>
    <div class="card-body table-responsive">
      <x-adminlte-datatable id="furnitureTable" :heads="$heads" :config="$config" />
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
  <x-modal title="Appliance - Furniture" id="modal-furniture" type="" icon="fas fa-chair">
    <livewire:management.furnitures-form :company="$company"/>
  </x-modal>
@stop

@section('footer')
  @include('includes.footer')
@stop

@section('js')
  <script type="text/javascript" src="{{asset('js/company.js')}}"></script>
@stop