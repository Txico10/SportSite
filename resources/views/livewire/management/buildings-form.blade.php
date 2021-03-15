<form wire:submit.prevent="saveBuildingForm" id="buildingform">
    <div class="form-group">
        @error('lot')
            <label for="name" class="text-danger">{{ $message }}</label>
        @enderror
        <div class="input-group mb-3" wire:ignore>
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-building"></i></span>
            </div>
            <input type="text" id="lot" class="form-control {{$errors->has("lot") ? 'is-invalid' : (  strlen($lot)>0 ? 'is-valid':'')}}" placeholder="Enter the lot">
        </div>
    </div>
    <div class="form-group">
        @error('alias')
            <label for="name" class="text-danger">{{ $message }}</label>
        @enderror
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-building"></i></span>
            </div>
            <input type="text" id="alias" class="form-control {{$errors->has("alias") ? 'is-invalid' : (  strlen($alias)>0 ? 'is-valid':'')}}" wire:model.lazy="alias" placeholder="Enter alias">
        </div>
    </div>
    <div class="form-group">
        @error('description')
            <label for="name" class="text-danger">{{ $message }}</label>
        @enderror
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-building"></i></span>
            </div>
            <textarea id="description" class="form-control {{$errors->has("description") ? 'is-invalid' : (  strlen($description)>0 ? 'is-valid':'')}}" wire:model.lazy="description" placeholder="Enter description" row="3"></textarea>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary float-right">{{ucfirst($submit_btn_title)}}</button>
    </div>
</form>
