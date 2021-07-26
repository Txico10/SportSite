@extends('adminlte::page')
@section('plugins.BootstrapSelect', true)
@section('plugins.Datatables', true)
@section('title', 'Apartments Setting')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Apartment Settings</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Settings</a></li>
                    <li class="breadcrumb-item active">Apartments</li>
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
    'Tag',
    'Description',
    'Creation date',
    'Action',
  ];

  //dd($company);
  $data = array();
  $btn = null;
  foreach ($company->apartmentTypes as $key => $apartmentType) {
      
    $btn = '<a class="btn btn-outline-primary btn-sm mx-1 shadow" type="button" title="More details" href="#"><i class="fas fa-info-circle fa-fw"></i></a>';
    
    if(Auth::user()->isAbleTo('apartmentType-update')){
        $btn = $btn.'<button class="btn btn-outline-secondary mx-1 shadow btn-sm editApartmentTypeButton" type="button" title="Edit Apartment Type" data-company="'.$company->id.'" value="'.$apartmentType->id.'"><i class="fas fa-pencil-alt fa-fw"></i></button>';
    }
    if(Auth::user()->isAbleTo('apartmentType-delete') && $apartmentType->apartments->count()==0){
        $btn = $btn.'<button class="btn btn-outline-danger mx-1 shadow btn-sm deleteApartmentTypeButton" title="Delete Apartment Type" type="button" data-company="'.$company->id.'" value="'.$apartmentType->id.'"><i class="fas fa-trash-alt fa-fw"></i></button>';
    }

    $mydata = [$key+1, ucfirst($apartmentType->name), $apartmentType->tag, ucfirst($apartmentType->description), \Carbon\Carbon::parse($apartmentType->created_at)->format('d F Y'), '<nobr>'.$btn.'</nobr>'];
    $data[]=$mydata;
  }
  
  $config = [
    'data'=>$data,
    'responsive'=> true,
    'order' => [[0,'asc']],
    'columns' => [null, null, null, null, null, ['orderable' => false]],
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
                                        <i class="fas fa-home"></i>
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
                                    <x-adminlte-datatable id="apartmentTypesTable" :heads="$heads" :config="$config" />
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
                                    <form method="POST" action="{{route('company.apartment-setting.store', ['company'=>$company])}}">
                                        @csrf
                                        <div class="form-group">
                                            @error('name')
                                                <label for="name" class="text-danger">{{ $message }}</label>
                                            @enderror
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-fw fa-home"></i></span>
                                                </div>
                                                <input type="text" id="name" name="name" class="form-control {{$errors->has("name") ? 'is-invalid' : ''}}" placeholder="Enter name">
                                                <input type="hidden" name="real_state_id" value="{{$company->id}}">
                                                <input type="hidden" id="apart_type_id" name="apart_type_id" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            @error('tag')
                                                <label for="tag" class="text-danger">{{ $message }}</label>
                                            @enderror
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-fw fa-tag"></i></span>
                                                </div>
                                                <input type="text" id="tag" name="tag" class="form-control {{$errors->has("tag") ? 'is-invalid' : ''}}" placeholder="Enter tag">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            @error('description')
                                                <label for="description" class="text-danger">{{ $message }}</label>
                                            @enderror
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-fw fa-comment"></i></span>
                                                </div>
                                                <textarea class="form-control {{$errors->has("description") ? 'is-invalid' : ''}}" id="description" name="description" placeholder="Apartment type" rows="3"></textarea>
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