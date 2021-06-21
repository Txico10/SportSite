<div class="card" id="furnitureList">
    <div class="card-header" wire:ignore id="for-bootstrap-select">  
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
                @if($furnitures->count()>0)
                <th>
                  <a wire:click.prevent="sortBy('code')" role="button" href="#">Code
                    @include('includes._sort-icon', ['field' => 'code'])
                  </a>
                </th>
                <th>
                  <a wire:click.prevent="sortBy('type')" role="button" href="#">Type
                    @include('includes._sort-icon', ['field' => 'type'])
                  </a>
                </th>
                <th>
                  <a wire:click.prevent="sortBy('manufacturer')" role="button" href="#">Manufacturer
                    @include('includes._sort-icon', ['field' => 'manufacturer'])
                  </a>
                </th>
                <th>
                  <a wire:click.prevent="sortBy('model')" role="button" href="#">Model
                    @include('includes._sort-icon', ['field' => 'model'])
                  </a>
                </th>
                <th>
                  <a wire:click.prevent="sortBy('serial')" role="button" href="#">Serial
                    @include('includes._sort-icon', ['field' => 'serial'])
                  </a>
                </th>
                <th>
                    <a wire:click.prevent="sortBy('buy_at')" role="button" href="#">Aquired
                      @include('includes._sort-icon', ['field' => 'buy_at'])
                    </a>
                </th>
                <th>
                    <a wire:click.prevent="sortBy('salvage_at')" role="button" href="#">Status
                      @include('includes._sort-icon', ['field' => 'salvage_at'])
                    </a>
                </th>
                @else
                <th>Code</th>
                <th>Type</th>
                <th>
                  Manufacturer
                </th>
                <th>
                  Model
                </th>
                <th>
                  Serial  
                </th>
                <th>
                    Aquired  
                </th>
                <th>
                    Status
                </th>
                @endif
                
                <th>
                  @permission('furniture-create')
                    <button class="btn btn-sm btn-outline-primary" type="button" data-toggle="modal" data-target="#modal-furniture" style="width: 98px"><i class="fas fa-plus"></i> Add</button>
                  @endpermission
                </th>
              </tr>
            </thead>
            <tbody>
              @forelse($furnitures as $key=>$furniture)
              <tr>
                <td>{{$furniture->code}}</td>
                <td>{{ucfirst($furniture->furnitureType->description)}}</td>
                <td>{{ucfirst($furniture->manufacturer)}}</td>
                <td>{{strtoupper($furniture->model)}}</td>
                <td>{{strtoupper($furniture->serial)}}</td>
                <td>{{$furniture->buy_at}}</td>
                <td>{{$furniture->salvage_at==null?"Active":$furniture->salvage_at}}</td>
                <td>
                    <button class="btn btn-sm btn-outline-secondary" type="button"><i class="fas fa-info-circle"></i></button>
                  @permission('furniture-update')
                  <button class="btn btn-sm btn-outline-info" type="button" wire:click.prevent="$emit('editFurniture', {{$furniture->id}})"><i class="fas fa-pencil-alt"></i></button>
                  @endpermission
                  @permission('furniture-delete')
                    <button class="btn btn-sm btn-outline-danger" type="button"><i class="fas fa-trash-alt"></chairbutton>
                  @endpermission
                </td>
              </tr>            
              @empty
                <p>No furniture registred</p>
              @endforelse
            </tbody>
        </table>    
    </div>
    {{ $furnitures->links() }}
    <x-modal title="Appliance - Furniture" id="modal-furniture" type="" icon="fas fa-chair">
      <livewire:management.furnitures-form :company="$company"/>
    </x-modal>
</div>
