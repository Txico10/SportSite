@extends('adminlte::page')
@section('plugins.BootstrapSelect', true)
@section('plugins.Datatables', true)
@section('title', 'Furniture Settings')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Appliances & Furnitures</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Settings</a></li>
                    <li class="breadcrumb-item active">Appliances & Furnitures</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@stop

@section('content')
@php
  $heads = [
    '#',
    'Type',
    'Description',
    'Creation date',
    'Action',
  ];

  //dd($company);
  $data = array();
  $btn = null;
  foreach ($company->furnitureTypes as $key => $furnitureType) {
      
    $btn = '<a class="btn btn-outline-primary btn-sm mx-1 shadow" type="button" title="More details" href="#"><i class="fas fa-info-circle fa-fw"></i></a>';
    
    if(Auth::user()->isAbleTo('furnitureType-update')){
        $btn = $btn.'<button class="btn btn-outline-secondary mx-1 shadow btn-sm editFurnitureTypeButton" type="button" title="Edit Furniture Type" data-company="'.$company->id.'" value="'.$furnitureType->id.'"><i class="fas fa-pencil-alt fa-fw"></i></button>';
    }
    if(Auth::user()->isAbleTo('furnitureType-delete') && $furnitureType->furnitures->count()==0){
        $btn = $btn.'<button class="btn btn-outline-danger mx-1 shadow btn-sm deletefurnitureTypeButton" title="Delete Furniture Type" type="button" data-company="'.$company->id.'" value="'.$furnitureType->id.'"><i class="fas fa-trash-alt fa-fw"></i></button>';
    }

    $mydata = [$key+1, $furnitureType->type==="A"?"Appliance":"Furniture", ucfirst($furnitureType->description), \Carbon\Carbon::parse($furnitureType->created_at)->format('d F Y'), '<nobr>'.$btn.'</nobr>'];
    $data[]=$mydata;
  }
  
  $config = [
    'data'=>$data,
    'responsive'=> true,
    'order' => [[0,'asc']],
    'columns' => [null, null, null, null, ['orderable' => false]],
  ]
@endphp

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- Default box -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 table-responsive">
                            <div class="card card-lightblue card-outline">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fas fa-couch"></i>
                                        Types list
                                    </h5>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if(session('success'))
                                        <x-adminlte-alert theme="success" title="Success" dismissable>
                                            {{session('success')}}
                                        </x-adminlte-alert>
                                    @endif
                                    <x-adminlte-datatable id="furnitureTypesTable" :heads="$heads" :config="$config" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-lightblue card-outline">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fas fa-edit"></i>
                                        Create type
                                    </h5>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{route('company.furniture-setting.store', ['company'=>$company])}}">
                                        @csrf
                                        <div class="form-group">
                                            @error('type')
                                                <label for="name" class="text-danger">{{ $message }}</label>
                                            @enderror
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-fw fa-chair"></i></span>
                                                </div>
                                                <select name="furniture_type" id="furniture_type" style="width: 80.5%" data-placeholder="Select type" data-allow-clear="true">
                                                    <option value=""></option>
                                                    <option value="A">Appliance</option>
                                                    <option value="F">Furniture</option>
                                                </select>
                                                <input type="hidden" name="real_state_id" value="{{$company->id}}">
                                                <input type="hidden" id="furniture_type_id" name="furniture_type_id" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            @error('description')
                                                <label for="tag" class="text-danger">{{ $message }}</label>
                                            @enderror
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-fw fa-tag"></i></span>
                                                </div>
                                                <input type="text" id="description" name="description" class="form-control {{$errors->has("description") ? 'is-invalid' : ''}}" placeholder="Enter description">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <x-adminlte-button class="shadow float-right" type="submit" label="Save" theme="outline-primary" icon="fas fa-lg fa-save"/>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@stop

@section('js')
    <script type="text/javascript" src="{{asset('js/company.js')}}"></script>
@stop