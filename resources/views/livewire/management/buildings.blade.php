<div class="card">
    <div class="card-header">
      <!-- Add drop box -->
      <div class="card-tools">
        <div class="input-group input-group-sm" style="width: 150px;">
            <input type="text" wire:model="search" name="search" class="form-control float-right" placeholder="Search" wire:loading.attr="disabled">
            <div class="input-group-append">
              <button class="btn btn-default"><i class="fas fa-search"></i></button>
            </div>
        </div>
      </div>
    </div>
    <div class="card-body">
      <table class="table table-hover text-wrap">
        <thead>
          <tr>
            @if($buildings->count()>0)
            <th style="width: 10%">
              <a wire:click.prevent="sortBy('lot')" role="button" href="#">Lot
                @include('includes._sort-icon', ['field' => 'lot'])
              </a>
            </th>
            <th  style="width: 15%">
              <a wire:click.prevent="sortBy('alias')" role="button" href="#">Alias
                @include('includes._sort-icon', ['field' => 'alias'])
              </a>
            </th>
            <th>
              <a wire:click.prevent="sortBy('description')" role="button" href="#">Description
                @include('includes._sort-icon', ['field' => 'description'])
              </a>
            </th>
            @else
            <th>
              Lot
            </th>
            <th>
              Alias
            </th>
            <th>
              Description  
            </th>
            @endif
            
            <th>Address</th>
            <th>
              @permission('building-create')
                <button class="btn btn-sm btn-outline-primary" type="button" data-toggle="modal" data-target="#modal-building" style="width: 98px"><i class="fas fa-plus"></i> Add</button>
              @endpermission
            </th>
          </tr>
        </thead>
        <tbody>
          @forelse($buildings as $building)
          <tr>
            <td>{{$building->lot}}</td>
            <td>{{$building->alias}}</td>
            <td>
              @if(empty($building->description))
              N/A
              @else
              {{Str::limit($building->description, 60, '...')}}
              @endif
            </td>
            <td>
              @if(!empty($building->contact->num))
              {{$building->contact->num}}, 
              @endif
              @if(!empty($building->contact->street))
              {{$building->contact->street}}, 
              @endif
              @if(!empty($building->contact->city))
              {{$building->contact->city}}, 
              @endif
              @if(!empty($building->contact->region))
              {{$building->contact->region}}, 
              @endif
              @if(!empty($building->contact->country))
              {{$building->contact->country}}, 
              @endif
              @if(!empty($building->contact->pc))
              {{$building->contact->pc}}
              @endif
            </td>
            <td>
              @permission('building-update')
              <button class="btn btn-sm btn-outline-info" type="button" wire:click.prevent="$emit('editBuilding', {{$building}})"><i class="fas fa-pencil-alt"></i></button>
              <button class="btn btn-sm btn-outline-secondary" type="button" wire:click.prevent="$emit('editContact', {{$building->contact}})"><i class="fas fa-map-marker-alt"></i></button>
              @endpermission
              @permission('building-delete')
                <button class="btn btn-sm btn-outline-danger" type="button"><i class="fas fa-trash-alt"></i></button>
              @endpermission
            </td>
          </tr>            
          @empty
            <p>No building registred</p>
          @endforelse
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
    {{ $buildings->links() }}
    <!-- /.card-footer-->
    <x-modal title="Building" id="modal-building" type="" icon="fas fa-building">
      <livewire:management.buildings-form :company="$company"/>  
    </x-modal>
    <x-modal title="Contact" id="modal-contact" type="" icon="">
      <livewire:management.contact-form/>
    </x-modal>
</div>
<!-- /.card -->
  


