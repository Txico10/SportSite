@extends('adminlte::page')
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
    'Created at',
    'Action',
  ];

  $config = [
    'processing' => true,
    'serverSide' => true,
    'ajax' => ['headers'=> ['X-CSRF-TOKEN'=>csrf_token()], 'url'=> route('company.furniture-setting', ['company'=>$company])],
    'responsive'=> true,
    'order' => [[0,'asc']],
    'columns' => [['data'=>'DT_RowIndex'], ['data'=>'type'], ['data'=>'description'], ['data'=>'created_at'], ['data'=>'action', 'searchable'=>false, 'orderable' => false]],
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
                                            @error('furniture_types_type')
                                                <label for="tag" class="text-danger">{{ $message }}</label>
                                            @enderror
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-fw fa-chair"></i></span>
                                                </div>
                                                <select class="form-control" name="furniture_types_type" id="furniture_types_type" style="width: 80.5%" data-placeholder="Select type" data-allow-clear="true">
                                                    <option value=""></option>
                                                    <option value="A">Appliance</option>
                                                      <option value="F">Furniture</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            @error('furniture_types_id')
                                                <label for="tag" class="text-danger">{{ $message }}</label>
                                            @enderror
                                            <input class="form-control" type="hidden" id="furniture_types_id", name="furniture_types_id" value="">
                                            <input class="form-control" type="hidden" id="real_state_id", name="real_state_id" value="{{$company->id}}">
                                        </div>
                                        <div class="form-group">
                                            @error('furniture_types_description')
                                                <label for="tag" class="text-danger">{{ $message }}</label>
                                            @enderror
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-fw fa-tag"></i></span>
                                                </div>
                                                <input type="text" id="furniture_types_description" name="furniture_types_description" class="form-control @error('furniture_types_description') is-invalid @enderror" placeholder="Enter description">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <x-adminlte-button class="shadow" id="reset_button" type="reset" label="Reset" theme="outline-danger" icon="fas fa-lg fa-trash"/>
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
    <script type="text/javascript">
    $(function(){
        $('#furniture_types_type').select2({
            width: 'resolve',
            theme: 'bootstrap4',
        });

        $("#reset_button").on("click", function(){
            $("#furniture_types_type").empty().trigger('change')
        })

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#furnitureTypesTable").on("click", ".editFurnitureTypeButton",function(event){
            event.preventDefault();
            var furniture_type_id = $(this).val();

            $.ajax({
                url:"{{route('company.furniture-setting.edit', ['company'=>$company])}}",
                type: "POST",
                dataType: "json",
                cache: false,
                data:{
                    furniture_type_id:furniture_type_id,
                },
                success: function(response) {
                  console.log(response)
                  $("#furniture_types_id").val(response.furniture_type.id)
                  $("#furniture_types_type option[value="+response.furniture_type.type+"]").prop('selected',true).trigger('change');
                  $("#furniture_types_description").val(response.furniture_type.description)
                  //console.log()
                },
                error: function(response, textStatus){
                  $.each(response.responseJSON.errors, function(key, value){
                    toastr[textStatus](value);
                  })
                }
            });
        });

        $("#furnitureTypesTable").on("click", ".deleteFurnitureTypeButton", function(event){
            event.preventDefault();
            var furniture_type_id = $(this).val();

            Swal.fire({
                title: 'The furniture type will be deleted!',
                text: 'Are You Sure?',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete!'
            }).then((result) => {
                //if user clicks on delete
                if (result.value) {
                  $.ajax({
                    url:"{{route('company.furniture-setting.destroy', ['company'=>$company])}}",
                    type: "DELETE",
                    dataType: "json",
                    cache: false,
                    data:{
                      furniture_type_id:furniture_type_id
                    },
                    success: function(response) {
                      //toastr.options.onHidden = function() { location.reload() }
                      $("#furnitureTypesTable").DataTable().ajax.reload();
                      toastr[response.type](response.message);
                      //setTimeout(function () { location.reload(); 5000});
                    },
                    error: function(response, textStatus){
                      $.each(response.responseJSON.errors, function(key, value){
                        toastr[textStatus](value);
                      })
                    }
                  });
                }
            });
        });
    })
    </script>
@stop
