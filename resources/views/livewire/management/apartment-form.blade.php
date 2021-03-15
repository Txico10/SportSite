<form wire:submit.prevent="saveApartmentForm" id="apartmentform">
    <div class="form-group">
        @error('apart_building')
            <label for="name" class="text-danger">{{ $message }}</label>
        @enderror
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-building"></i></span>
            </div>
            <select class="form-control" name="apart_building" id="apart_building" wire:model="apart_building" data-placeholder="Select building" data-allow-clear="true" style="width: 91.5%">
                <option value=""></option>
                @forelse($apartbuildings as $key => $value)
                    <option value={{$key}}>{{$value}}</option>
                @empty
                    <option value="-1">No Building available</option>    
                @endforelse    
            </select>
        </div>
    </div>
    <div class="form-group">
        @error('apart_type')
            <label for="name" class="text-danger">{{ $message }}</label>
        @enderror
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-building"></i></span>
            </div>
            <select class="form-control" name="apart_type" id="apart_type" wire:model="apart_type" data-placeholder="Select apartment type" data-allow-clear="true" style="width: 91.5%">
                <option value=""></option>
                @forelse($apartypes as $key => $value)
                    <option value={{$key}}>{{$value}}</option>
                @empty
                    <option value="-1">No apartment types available</option>    
                @endforelse    
            </select>
        </div>
    </div>
    <div class="form-group">
        @error('apart_number')
            <label for="name" class="text-danger">{{ $message }}</label>
        @enderror
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-building"></i></span>
            </div>
            <input type="text" id="apart_number" class="form-control {{$errors->has("apart_number") ? 'is-invalid' : (  strlen($apart_number)>0 ? 'is-valid':'')}}" wire:model.lazy="apart_number" placeholder="Apartment number">
        </div>
    </div>
    <div class="form-group">
        @error('apart_description')
            <label for="name" class="text-danger">{{ $message }}</label>
        @enderror
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-building"></i></span>
            </div>
            <textarea id="apart_description" class="form-control {{$errors->has("apart_description") ? 'is-invalid' : (  strlen($apart_description)>0 ? 'is-valid':'')}}" wire:model.lazy="apart_description" placeholder="Enter description" row="3"></textarea>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary float-right">{{ucfirst($submit_btn_title)}}</button>
    </div>
</form>
