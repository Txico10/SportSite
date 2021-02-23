<form wire:submit.prevent="savePassword" id="resetForm">
    <div class="form-group">
        @error('oldpassword')
            <label class="text-danger">{{ $message }}</label>
        @enderror
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
            </div>
            <input type="password" id="oldpassword" class="form-control {{$errors->has("oldpassword") ? 'is-invalid' : (  strlen($oldpassword)>0 ? 'is-valid':'')}}" wire:model.lazy="oldpassword" placeholder="Current password">
        </div>
    </div>
    <div class="form-group">
        @error('new_password')
            <label class="text-danger">{{ $message }}</label>
        @enderror
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
            </div>
            <input type="password" id="new_password" class="form-control {{$errors->has("new_password") ? 'is-invalid' : (  strlen($new_password)>0 ? 'is-valid':'')}}" wire:model.lazy="new_password" placeholder="New password">
        </div>
    </div>
    <div class="form-group">
        @error('new_password_confirmation')
            <label class="text-danger">{{ $message }}</label>
        @enderror
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
            </div>
            <input type="password" id="new_password_confirmation" class="form-control {{$errors->has("new_password_confirmation") ? 'is-invalid' : (  strlen($new_password_confirmation)>0 ? 'is-valid':'')}}" wire:model.lazy="new_password_confirmation" placeholder="Retype new password">
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary float-right">Reset</button>
    </div>
</form>
