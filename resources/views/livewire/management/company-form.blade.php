<form wire:submit.prevent="saveForm" id="companyform">
    <div class="form-group">
        <div class="input-group pb-3">
            @if(!empty($logo))
                <img class="profile-user-img img-fluid img-circle" src="{{ ($logo===$old_logo) ? asset('storage/profile_images/companies/'.$logo) : $logo->temporaryUrl()}}" alt="Company profile picture">
            @else
                <img class="profile-user-img img-fluid img-circle" src="https://picsum.photos/128/128" alt="Company profile picture">
            @endif
        </div>
        <div wire:loading wire:target="logo">Uploading...</div>
        <div class="input-group">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="logo" wire:model="logo">
                <label class="custom-file-label" for="logo">Choose file</label>
            </div>
        </div>
        @error('logo')
            <label for="name" class="text-danger">{{ $message }}</label>
        @enderror
    </div>
    <div class="form-group">
        @error('name')
            <label for="name" class="text-danger">{{ $message }}</label>
        @enderror
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-building"></i></span>
            </div>
            <input type="text" id="name" class="form-control {{$errors->has("name") ? 'is-invalid' : (  strlen($name)>0 ? 'is-valid':'')}}" wire:model="name" placeholder="Enter name">
        </div>
    </div>
    <div class="form-group">
        @error('neq')
            <label class="text-danger">{{ $message }}</label>
        @enderror
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
            </div>
            <input type="text" id="neq" disabled class="form-control {{$errors->has("neq") ? 'is-invalid' : (  strlen($neq)>0 ? 'is-valid':'')}}" wire:model="neq" placeholder="Enter NEQ">
        </div>
    </div>
    <div class="form-group">
        @error('legalform')
            <label class="text-danger">{{ $message }}</label>
        @enderror
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
            </div>
            <select name="legalform" id="legalform" wire:model="legalform" data-placeholder="Enter Legal form" style="width: 92%">
                <option value=""></option>
                <option value="Sole proprietorship">Sole proprietorship</option>
                <option value="Business corporation">Business corporation</option>
                <option value="General partnership">General partnership</option>
                <option value="Limited partnership">Limited partnership</option>
                <option value="Cooperative">Cooperative</option>
            </select>
        </div>
    </div>    
    <div class="form-group">
        <button type="submit" class="btn btn-primary float-right">Save</button>
    </div>
</form>