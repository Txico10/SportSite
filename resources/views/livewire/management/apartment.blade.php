<div class="card" id="apartmentsList">
    <div class="card-header" wire:ignore id="for-bootstrap-select">
       
        <select name="myBuildings" id="myBuildings" wire:model="buildingId" data-container="#for-bootstrap-select" data-width="150px" data-title="Select building" data-live-search="true">
          @if(!empty($myBuildings))
            <option value="-1">All buildings</option>
          @endif
          @forelse($myBuildings as $key=>$value)
            <option value="{{$key}}">{{$value}}</option>
          @empty
            <option value="-2">No Building</option>
          @endforelse
        </select>
      
      <div class="card-tools">
        <div class="input-group input-group-sm" style="width: 150px;">
            <input type="text" wire:model="search" name="search" class="form-control float-right" placeholder="Search">
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
            @if(!empty($apartments) && $apartments->count()>0)
            <th>
              <a wire:click.prevent="sortBy('number')" role="button" href="#">Apt
                @include('includes._sort-icon', ['field' => 'number'])
              </a>
            </th>
            @else
            <th>
              Apt
            </th>
            @endif
            
            <th>Type</th>
            <th>Building</th>
            <th>Locataire</th>
            <th>
              @permission('apartment-create')
              <button class="btn btn-sm btn-outline-primary" type="button" data-toggle="modal" data-target="#modal-apartment" style="width: 98px"><i class="fas fa-plus"></i> Add</button>
              @endpermission
            </th>
          </tr>
        </thead>
        <tbody>
          @if(!empty($apartments))
          @forelse($apartments as $apartment)
          <tr>
            <td>{{$apartment->number}}</td>
            <td>
                <span class="badge bg-success">{{$apartment->apartmentType->tag}}</span>
            </td>
            <td>
                <span class="badge bg-primary">{{$apartment->building->lot}}</span>
            </td>
            <td>
                Stefan Monteiro
            </td>
            <td>
              <button class="btn btn-sm btn-outline-primary" type="button"><i class="fas fa-user-cog"></i></button>
              <a class="btn btn-sm btn-outline-success" type="button" href="{{route('company.apartment.furnitures', ['id'=>$company->id, 'apartment'=>$apartment])}}"><i class="fas fa-chair"></i></a>
              @permission('apartment-update')
                <button class="btn btn-sm btn-outline-info" type="button" wire:click.prevent="$emit('editApartment', {{$apartment->id}})"><i class="fas fa-pencil-alt"></i></button>
              @endpermission
              @permission('apartment-delete')
                <button class="btn btn-sm btn-outline-danger" type="button"><i class="fas fa-trash-alt"></i></button>
              @endpermission
            </td>
          </tr>  
          @empty
            <p>No Appartment registred</p>
          @endforelse
          @else
          <p>No Appartment registred</p>
          @endif
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
    @if(!empty($apartments) && $apartments->count()>0)
    {{ $apartments->links() }}
    @endif    
    <!-- /.card-footer-->
    <x-modal title="Apartment" id="modal-apartment" type="" icon="fas fa-home">
      <livewire:management.apartment-form :company="$company"/>  
    </x-modal>
</div>
  <!-- /.card -->    
