@extends('adminlte::page')
@section('title', 'Furnitures')
@section('plugins.Datatables', true)
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Furniture details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{route('company.furnitures', ['company'=>$company])}}">Furnitures</a></li>
              <li class="breadcrumb-item active">Furniture</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@stop

@section('content')
  <div class="row">
    <div class="col-md-3">
      <div class="card">
        <div class="card-header bg-lightblue">
          <h3 class="card-title">
            <i class="fas fa-info-circle"></i>
            Description
          </h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-fw fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-fw fa-times"></i>
            </button>
        </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <dl class="row">
            <dt class="col-sm-4">Type</dt>
            <dd class="col-sm-8">{{ucfirst($furniture->furnitureType->description)}}</dd>
            <dt class="col-sm-4">Manufacturer</dt>
            <dd class="col-sm-8">{{ucfirst($furniture->manufacturer)}}</dd>
            <dt class="col-sm-4">Model</dt>
            <dd class="col-sm-8">{{strtoupper($furniture->model)}}</dd>
            <dt class="col-sm-4">Serial</dt>
            <dd class="col-sm-8">{{strtoupper($furniture->serial)}}</dd>
            <dt class="col-sm-4">Aquisition</dt>
            <dd class="col-sm-8">{{\Carbon\Carbon::parse($furniture->buy_at)->format('d F Y')}}</dd>
            <dt class="col-sm-4">Discontinued</dt>
            <dd class="col-sm-8">{{!empty($furniture->salvage_at)?\Carbon\Carbon::parse($furniture->salvage_at)->format('d F Y'): 'N/A'}}</dd>
            @if(empty($furniture->salvage_at))
              <dt class="col-sm-4">Action</dt>
              <dd class="col-sm-8">
                @if(empty($furnitureAssignement))
                  <x-adminlte-button class="btn-sm" type="button" label="Assign" theme="outline-success" icon="fas fa-lg fa-sign-in-alt" data-toggle="modal" data-target="#modal-furnitureAssignement"/>
                @else
                  <form action="{{route('company.furniture.withdraw', ['company'=>$company, 'furniture'=>$furniture, 'apartment'=>$furnitureAssignement->apartment_id])}}" method="post">
                    @csrf
                    <input type="hidden" name="assigned_at" value="{{$furnitureAssignement->assigned_at}}">
                    <x-adminlte-button class="btn-sm" type="submit" label="Widthdraw" theme="outline-danger" icon="fas fa-lg fa-sign-out-alt"/>
                  </form>
                @endif
              </dd>
            @endif
          </dl>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- ./col -->
    <div class="col-md-9">
      @if(session('status'))
        <x-adminlte-alert theme="success" title="Success" dismissable>
          {{session('status')}}
        </x-adminlte-alert>
      @endif
      @error('assigned_at')
        <x-adminlte-alert theme="danger" title="Error" dismissable>
          The assignement date cant be greater then the withdraw date
        </x-adminlte-alert>
      @enderror
      @php
        $heads = [
          'Building',
          'Apartment',
          'Assigned',
          'Withdraw',
          'Action'
        ];

        $data = array();
        foreach ($furniture->apartments as $key => $apartment) {
          $withdraw = null;
          $btn = null;
          if(!empty($apartment->pivot->withdraw_at)) {
            $withdraw = \Carbon\Carbon::parse($apartment->pivot->withdraw_at)->format('d F Y');
          } else{
            $btn='<button id="DeleteAssignFurniture" class="btn btn-sm btn-default text-danger mx-1 shadow" title="Delete" value="'.$apartment->pivot->id.'"><i class="fas fa-fw fa-trash-alt"></i></button>';
          }
          $mydata = [$apartment->building->alias, $apartment->number, \Carbon\Carbon::parse($apartment->pivot->assigned_at)->format('d F Y'), $withdraw, '<nobr>'.$btn.'</nobr>'];
          array_push($data, $mydata);
        }
        //dd($furniture->furnitureAssigned()->apartment_id);
        $config = [
          'data'=>$data,
          'responsive'=> true,
          'order' => [[3,'asc']],
          'columns' => [null, null, null, null, ['orderable' => false]],
        ]
      @endphp
      <div class="card">
        <div class="card-header bg-lightblue">
          <h3 class="card-title">
            <i class="fas fa-chair"></i>
            Furniture history
          </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
          <x-adminlte-datatable id="furniture_history" :heads="$heads" :config="$config" />
        </div>
        <!-- /.card-body -->
      </div>
    </div>
  </div>
  <x-modal title="Furniture Assignement" id="modal-furnitureAssignement" type="" icon="fas fa-sign-in-alt">
    @livewire('management.furnitures-apartment-form', ['company'=>$company,'furniture'=>$furniture])
  </x-modal>
@stop

@section('footer')
  @include('includes.footer')
@stop

@section('js')
  <script type="text/javascript" src="{{asset('js/company.js')}}"></script>
@stop
