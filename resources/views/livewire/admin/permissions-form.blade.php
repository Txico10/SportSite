<form wire:submit.prevent="savePermissionForm">
    <div class="form-group">
        @error('name')
            <label for="name" class="text-danger">{{ $message }}</label>
        @enderror    
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
            </div>
            <input type="text" id="name" class="form-control {{$errors->has("name") ? 'is-invalid' : (  strlen($name)>0 ? 'is-valid':'')}}" wire:model.lazy="name" placeholder="Enter permission tag">
            @if(strcmp($submit_btn_title,"Update")==0)
                <input type="hidden" wire:model="permission_id" >
            @endif
        </div>
    </div>
    <div class="form-group">
        @error('display_name')
            <label for="display_name" class="text-danger">{{ $message }}</label>
        @enderror
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            </div>
            <input type="text" id="display_name" class="form-control {{$errors->has("display_name") ? 'is-invalid' : (  strlen($display_name)>0 ? 'is-valid':'')}}" wire:model.lazy="display_name" placeholder="Enter permission name">
        </div>
    </div>

    <div class="form-group">
        @error('description')
            <label class="text-danger" for="description">{{ $message }}</label>
        @enderror
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            </div>
            <textarea id="description" class="form-control {{$errors->has("description") ? 'is-invalid' : (  strlen($description)>0 ? 'is-valid':'')}}" rows="3" wire:model.lazy="description" placeholder="Enter permission description"></textarea>        
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary float-right">{{$submit_btn_title}}</button>
    </div>
</form>
