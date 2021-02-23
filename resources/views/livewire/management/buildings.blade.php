<div class="card">
    <div class="card-header">
      <!-- Add drop box -->
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
            <th style="width: 17%">
              <a wire:click.prevent="sortBy('lot')" role="button" href="#">Lot
                @include('includes._sort-icon', ['field' => 'lot'])
              </a>
            </th>
            <th>
              <a wire:click.prevent="sortBy('description')" role="button" href="#">Description
                @include('includes._sort-icon', ['field' => 'description'])
              </a>
            </th>
            <th>Address</th>
            <th style="width: 15%">
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
            <td>
              @if(empty($building->description))
              N/A
              @else
              {{Str::limit($building->description, 60, '...')}}
              @endif
            </td>
            <td>
              {{$building->contact->num}},
              {{$building->contact->street}},
              {{$building->contact->city}},
              {{$building->contact->region}},
              {{$building->contact->country}}
            </td>
            <td>
              @permission('building-update')
              <button class="btn btn-sm btn-outline-info" type="button"><i class="fas fa-pencil-alt"></i></button>
              <button class="btn btn-sm btn-outline-secondary" type="button" wire:click="$emit('editContact',{{ $building->contact->id }})"><i class="fas fa-map-marker-alt"></i></button>
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
</div>
<!-- /.card -->
<x-modal title="Building" id="modal-building" type="">
  @if (isset($building))
  <livewire:management.buildings-form :id="$building->id" />    
  @else
  <livewire:management.buildings-form/>
  @endif  
</x-modal>  


