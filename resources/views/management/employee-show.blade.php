@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', 'Employee Profile')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Employee profile</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              @permission('company-read')
              <li class="breadcrumb-item"><a href="{{route('company.profile', ['company'=>$company])}}">Company</a></li>
              @endpermission
              @permission('employee-read')
              <li class="breadcrumb-item"><a href="{{route('company.employees', ['company'=>$company])}}">Employees</a></li>
              <li class="breadcrumb-item active">{{$employee->name}}</li>
              @endpermission
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@stop

@section('content')
@php
    $heads = [
        '#',
        'User',
        'Role',
        'Status',
        'Start Date',
        'End Date',
        'Agreement',
        'Action',
    ];

    $config = [
        'processing' => true,
        'serverSide' => true,
        'ajax' => ['headers'=> ['X-CSRF-TOKEN'=>csrf_token()], 'url'=> route('company.employees.show', ['company'=>$company, 'employee'=>$employee])],
        //'data'=>$data,
        'responsive'=> true,
        'order' => [[4,'desc']],
        'columns' => [['data'=>'DT_RowIndex', 'searchable'=>false], ['data'=>'user_status'], ['data'=>'role'], ['data'=>'status'], ['data'=>'start_date'], ['data'=>'end_date'], ['data'=>'agreement'], [ 'data'=>'action', 'searchable'=>false, 'orderable' => false]],
    ]
@endphp
<div class="row">
    <div class="col-md-3">
        <x-adminlte-profile-widget name="{{$employee->name}}" theme="lightblue" img="{{is_null($employee->image)?'https://picsum.photos/id/1/100':asset('storage/profile_images/employees/'.$employee->image)}}" layout-type="classic">
            <x-adminlte-profile-row-item icon="fas fa-fw fa-venus-mars" class="mr-1 border-bottom" title="Gender" text="{{ucfirst($employee->gender)}}"/>
            <x-adminlte-profile-row-item icon="fas fa-fw fa-birthday-cake" class="mr-1 border-bottom" title="Birthdate" text="{{\Carbon\Carbon::parse($employee->birthdate)->format('d F Y')}}"/>
            <x-adminlte-profile-row-item icon="fas fa-fw fa-hashtag" class="mr-1" title="NAS" text="{{$employee->nas}}"/>
            @permission('employee-update')
                <button type="button" type="button" class="btn btn-primary btn-block" id="editEmployeeButton" value="{{$employee->id}}">Edit Employee</button>
            @endpermission
        </x-adminlte-profile-widget>
        <!--Contact-->
        <livewire:management.contact :contact="$employee->contact" />
    </div>
    <div class="col-md-9">
        <!-- Default box -->
        <div class="card card-lightblue">
            <div class="card-header">
                @permission('employee_agreement-create')
                <h3 class="card-title">
                    <button type="button" class="btn btn-tool" title="New agreement">
                        <i class="fas fa-fw fa-plus-square"></i>
                    </button>
                    Agreements
                </h3>
                @endpermission
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
                <x-adminlte-datatable id="employee_agreements_table" :heads="$heads" :config="$config" />
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <x-modal title="Edit Employee" id="modal-editEmployee" type="" icon="fas fa-user-edit">
            <livewire:management.employees-edit />
          </x-modal>
    </div>
</div>
@stop

@section('js')
<script type="text/javascript" src="{{asset('js/company.js')}}"></script>
<script type="text/javascript">
$(function(){
    $("#editEmployeeButton").on('click', function(){
        var employeeID = $(this).val()
        //console.log(employeeID)
        Livewire.emit('editEmployee', employeeID);
    });
})
</script>
@stop
