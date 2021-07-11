<form wire:submit.prevent="saveAssignForm" id="furnituteAssignForm">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                @error('building_id')
                    <label for="name" class="text-danger">{{ $message }}</label>
                @enderror
                <div class="input-group mb-3">
                    <div class="input-group-prepend" style="width: 10%">
                        <span class="input-group-text"><i class="fas fa-fw fa-building"></i></span>
                    </div>
                    <select class="form-control" name="companyBuildings" id="furniture_companyBuildings" wire:model="building_id" data-placeholder="Select building" data-allow-clear="true" style="width: 90%">
                        <option value=""></option>
                        @forelse($buildings as $key => $building)
                            <option value={{$building->id}}>{{$building->alias}}</option>
                        @empty
                            <option value="-1">No Building available</option>    
                        @endforelse    
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                @error('apartment_id')
                    <label for="name" class="text-danger">{{ $message }}</label>
                @enderror
                <div class="input-group mb-3">
                    <div class="input-group-prepend" style="width: 10%">
                        <span class="input-group-text"><i class="fas fa-fw fa-home"></i></span>
                    </div>
                    <select class="form-control" name="buildingApartments" id="furniture_buildingApartments" wire:model="apartment_id" data-placeholder="Select the apartment" data-allow-clear="true" style="width: 90%">
                        <option value=""></option>
                        @forelse($apartments as $key => $apartment)
                            <option value={{$apartment->id}}>{{$apartment->number}}-{{$apartment->description}}</option>
                        @empty
                            <option value="-1">Choose a building</option>    
                        @endforelse    
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                @error('assigned_at')
                    <label for="name" class="text-danger">{{ $message }}</label>
                @enderror
                <div class="input-group mb-3 date" id="furnitute-assignement-date" data-target-input="nearest" wire:ignore>
                    <div class="input-group-prepend" data-target="#furnitute-assignement-date" data-toggle="datetimepicker">
                      <span class="input-group-text"><i class="far fa-fw fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control datetimepicker-input furnitute-assignement-date {{$errors->has("assigned_at") ? 'is-invalid' : (strlen($assigned_at)>0 ? 'is-valid':'')}}" placeholder="Assignement date" data-target="#furnitute-assignement-date" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                  </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <button type="submit" class="btn btn-primary float-right">Save</button>
            </div>
        </div>
    </div>
</form>