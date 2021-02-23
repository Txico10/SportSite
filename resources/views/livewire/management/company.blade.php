<div class="card card-primary card-outline">
    <div class="card-body box-profile">
      <div class="text-center">
      <img class="profile-user-img img-fluid img-circle" src="{{asset('storage/profile_images/companies/'.$company->logo)}}" alt="{{$company->name}}">
      </div>

      <h3 class="profile-username text-center">{{$company->name}}</h3>

      @if(!empty($company->legalform))
      <p class="text-muted text-center">{{$company->legalform}}</p>
      @endif
      <ul class="list-group list-group-unbordered mb-3">
        @if(!empty($company->neq))
        <li class="list-group-item">
          <b>NEQ</b> <a class="float-right">{{$company->neq}}</a>
        </li>  
        @endif
      </ul>

      <button class="btn btn-primary btn-block" role="button" wire:click="$emit('editCompany',{{ $company->id }})"><b>Edit</b></button>
    </div>
    <!-- /.card-body -->
</div>
<x-modal title="Company" id="modal-company" type="">
    <livewire:management.company-form :id="$company->id" />
</x-modal>