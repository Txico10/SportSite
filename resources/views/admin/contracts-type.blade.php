@extends('adminlte::page')
@section('plugins.xpto', true)
@section('title', 'Contract Settings')
@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Contracts</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Settings</a></li>
                <li class="breadcrumb-item active">Contracts</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@stop

@section('content')
    <!-- Default box -->
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <!-- Default box -->
                    <div class="card card-lightblue card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Title</h3>
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
                            Start creating your amazing application! Part 1
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            Footer
                        </div>
                        <!-- /.card-footer-->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-7">
                    <!-- Default box -->
                    <div class="card card-lightblue card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Title</h3>

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
                            <form action="{{route('company.contract-setting.store', ['company'=>$company])}}" method="POST" enctype="multipart/form-data">
                                @csrf
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
                                    @error('contract_type_id')
                                        <label for="tag" class="text-danger">{{ $message }}</label>
                                    @enderror
                                    <input class="form-control" type="hidden" id="contract_type_id" name="contract_type_id" value="">
                                </div>
                                <div class="form-group">
                                    @error('description')
                                        <label for="description" class="text-danger">{{ $message }}</label>
                                    @enderror
                                    <textarea id="description" class="summernote" name="description"></textarea>
                                </div>
                                <div class="form-group">
                                    <x-adminlte-button class="shadow" type="reset" label="Reset" theme="outline-danger" icon="fas fa-lg fa-trash"/>
                                    <x-adminlte-button class="shadow float-right" type="submit" label="Save" theme="outline-primary" icon="fas fa-lg fa-save"/>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            Footer
                        </div>
                        <!-- /.card-footer-->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
@stop

@section('css')
<link href="{{ asset('/vendor/summernote/summernote.min.css')}}" rel="stylesheet">
@stop

@section('js')
<script src="{{asset('/vendor/summernote/summernote.min.js')}}"></script>
<script type="text/javascript">
    $(function(){
        $('#description').summernote({
            placeholder: 'Hello Bootstrap 4',
            tabsize: 2,
            height: 100
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

</script>
@stop
