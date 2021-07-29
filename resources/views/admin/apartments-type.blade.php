@extends('adminlte::page')
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
      'Created',
      'Action',
    ];

    $config = [
      'processing' => true,
      'serverSide' => true,
      'ajax' => ['headers'=> ['X-CSRF-TOKEN'=>csrf_token()], 'url'=> route('company.apartment-setting', ['company'=>$company])],
      'responsive'=> true,
      'order' => [[0,'asc']],
      'columns' => [['data'=>'DT_RowIndex'], ['data'=>'name'], ['data'=>'tag'], ['data'=>'description'], ['data'=>'created_at'], ['data'=>'action', 'searchable'=>false,'orderable' => false]],
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
                                                <label for="tag" class="text-danger">{{ $message }}</label>
                                            @enderror
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-fw fa-home"></i></span>
                                                </div>
                                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            @error('apart_type_id')
                                                <label for="tag" class="text-danger">{{ $message }}</label>
                                            @enderror
                                            <input class="form-control" type="hidden" name="real_state_id" value="{{$company->id}}">
                                            <input class="form-control" type="hidden" id="apart_type_id" name="apart_type_id" value="">
                                        </div>
                                        <div class="form-group">
                                            @error('tag')
                                                <label for="tag" class="text-danger">{{ $message }}</label>
                                            @enderror
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-fw fa-tag"></i></span>
                                                </div>
                                                <input type="text" id="tag" name="tag" class="form-control @error('tag') is-invalid @enderror" placeholder="Enter tag">
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
                                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Apartment type" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <x-adminlte-button class="shadow" type="reset" label="Reset" theme="outline-danger" icon="fas fa-lg fa-trash"/>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#apartmentTypesTable").on("click", ".editApartmentTypeButton", function(event){
            event.preventDefault();
            var apartment_type_id = $(this).val();

            $.ajax({
                url:"{{route('company.apartment-setting.edit', ['company'=>$company])}}",
                type: "POST",
                dataType: "json",
                cache: false,
                data:{
                    apartment_type_id:apartment_type_id
                },
                success: function(response) {
                    //console.log(response.apartment_type)
                    $("#apart_type_id").val(response.apartment_type.id)
                    $("#name").val(response.apartment_type.name)
                    $("#tag").val(response.apartment_type.tag)
                    $("#description").val(response.apartment_type.description)
                },
                error: function(response, textStatus){
                    $.each(response.responseJSON.errors, function(key, value){
                        toastr[textStatus](value);
                    })
                }
            });
          //console.log(apartment_type_id)
        });

        $("#apartmentTypesTable").on("click", ".deleteApartmentTypeButton", function(event){
            event.preventDefault();
            var apartment_type_id = $(this).val();
            Swal.fire({
                title: 'The apartment type will be deleted!',
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
                        url:"{{route('company.apartment-setting.destroy', ['company'=>$company])}}",
                        type: "DELETE",
                        dataType: "json",
                        cache: false,
                        data:{
                            apartment_type_id:apartment_type_id
                        },
                        success: function(response) {
                            //toastr.options.onHidden = function() { location.reload() }
                            $("#apartmentTypesTable").DataTable().ajax.reload();
                            toastr[response.type](response.message);
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
    </script>
@stop
