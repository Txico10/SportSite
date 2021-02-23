<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">My Contacts</h3>
        <div class="card-tools">
        <button type="button" class="btn btn-tool" wire:click="$emit('editContact',{{ $company->contact->id }})">
            <i class="fas fa-edit"></i></button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        
        <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

        <p class="text-muted">
        {{$company->contact->num}},
        {{$company->contact->street}},
        {{$company->contact->city}},
        {{$company->contact->region}},
        {{$company->contact->country}},
        {{$company->contact->pc}},
        {{$company->contact->suite}}
        </p>

        <hr>

        <strong><i class="fas fa-at mr-1"></i> Email</strong>

        <p class="text-muted">
        <span class="tag tag-danger">{{$company->contact->email}}</span>
        </p>

        <hr>

        <strong><i class="fas fa-phone-alt mr-1"></i> Phone</strong>

        <p class="text-muted">
        <span class="tag tag-danger">{{$company->contact->telephone}}</span>
        </p>

        <hr>

        <strong><i class="fas fa-mobile-alt mr-1"></i> Mobile</strong>

        <p class="text-muted">{{$company->contact->mobile}}</p>
    </div>
    <!-- /.card-body -->
</div>
<x-modal title="Contact" id="modal-contact" type="modal-lg">
    <livewire:management.contact-form :id="$company->contact->id" />
</x-modal>