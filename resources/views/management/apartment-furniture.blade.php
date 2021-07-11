@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', 'Apartment Furnitures')

@section('content_header')
    <h1>Apartment Furnitures</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-info-circle"></i>
                    Apartment
                  </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <dl class="row">
                    <dt class="col-sm-4">Building</dt>
                    <dd class="col-sm-8">{{$apartment->building->alias}}</dd>
                    <dt class="col-sm-4">Apartment</dt>
                    <dd class="col-sm-8">{{$apartment->number}}</dd>
                    <dt class="col-sm-4">Type</dt>
                    <dd class="col-sm-8">{{$apartment->ApartmentType->tag}} - {{$apartment->ApartmentType->name}}</dd>
                    <dt class="col-sm-4">Description</dt>
                    <dd class="col-sm-8">{{$apartment->description}}</dd>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-9">
            @php
              $heads = [
                'Type',
                'Manufacturer',
                'Model',
                'Serial',
                'Aquired',
                'Status',
              ];
                    
              $data = array();
              $btn = null;
              foreach ($apartment->furnitures as $key => $furniture) {
                $withdraw = null;
                if(empty($furniture->salvage_at)){
                    $withdraw = "Active";
                }else{
                    $withdraw = \Carbon\Carbon::parse($furniture->salvage_at)->format('d F Y');
                }
            
                $mydata = [ucfirst($furniture->furnitureType->description),ucfirst($furniture->manufacturer),strtoupper($furniture->model),strtoupper($furniture->serial),\Carbon\Carbon::parse($furniture->pivot->assigned_at)->format('d F Y'), $withdraw];
                array_push($data, $mydata);
              }
              //dd($data);
              $config = [
                'data'=>$data,
                'responsive'=> true,
                'order' => [[0,'asc']],
                'columns' => [null, null, null, null, null, null],
              ]
            @endphp
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-chair"></i>
                    Furniture history
                  </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive">
                    <x-adminlte-datatable id="table2" :heads="$heads" :config="$config" compressed/>
                </div>
                <!-- /.card-body -->
              </div>
        </div>
    </div>
@stop

@section('js')
    
@stop