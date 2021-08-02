<div class="card card-lightblue">
    <div class="card-header">
        <h3 class="card-title">
            <button type="button" class="btn btn-tool" wire:click="$emit('editContact', {{$contact}})">
                <i class="fas fa-fw fa-edit"></i>
            </button>
            Contact
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

        <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

        <p class="text-muted">
        {{$contact->num}},
        {{$contact->street}},
        {{$contact->city}},
        {{$contact->region}},
        {{$contact->country}},
        {{$contact->pc}},
        {{$contact->suite}}
        </p>

        <hr>

        <strong><i class="fas fa-at mr-1"></i> Email</strong>

        <p class="text-muted">
        <span class="tag tag-danger">{{$contact->email}}</span>
        </p>

        <hr>

        <strong><i class="fas fa-phone-alt mr-1"></i> Phone</strong>

        <p class="text-muted">
        <span class="tag tag-danger">{{$contact->telephone}}</span>
        </p>

        <hr>

        <strong><i class="fas fa-mobile-alt mr-1"></i> Mobile</strong>

        <p class="text-muted">{{$contact->mobile}}</p>
    </div>
    <!-- /.card-body -->
    <x-modal title="Contact" id="modal-contact" type="" icon="fas fa-address-book">
        <livewire:management.contact-form/>
    </x-modal>
</div>
