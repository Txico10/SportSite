<form wire:submit.prevent="saveUserForm" id="userform">
    <div class="form-group">
        @error('name')
            <label for="name" class="text-danger">{{ $message }}</label>
        @enderror
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input type="text" id="name" class="form-control {{$errors->has("name") ? 'is-invalid' : (  strlen($name)>0 ? 'is-valid':'')}}" wire:model.lazy="name" placeholder="Enter name">
        </div>
    </div>
    <div class="form-group">
        @error('email')
            <label class="text-danger">{{ $message }}</label>
        @enderror
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-at"></i></span>
            </div>
            <input type="email" id="email" class="form-control {{$errors->has("email") ? 'is-invalid' : (  strlen($email)>0 ? 'is-valid':'')}}" wire:model.lazy="email" placeholder="Enter email">
        </div>
    </div>
    <div class="form-group">
        @error('password')
            <label class="text-danger">{{ $message }}</label>
        @enderror
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
            </div>
            <input type="password" id="password" class="form-control {{$errors->has("password") ? 'is-invalid' : (  strlen($password)>0 ? 'is-valid':'')}}" wire:model.lazy="password" placeholder="Password">
        </div>
    </div>
    <div class="form-group">
        @error('confirm_password')
            <label class="text-danger">{{ $message }}</label>
        @enderror
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
            </div>
            <input type="password" id="confirm_password" class="form-control {{$errors->has("confirm_password") ? 'is-invalid' : (  strlen($confirm_password)>0 ? 'is-valid':'')}}" wire:model.lazy="confirm_password" placeholder="Retype Password">
        </div>
    </div>
    <div class="form-group">
        @error('role')
            <label class="text-danger">{{ $message }}</label>
        @enderror
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-users-cog"></i></span>
            </div>
            <input type="text" id="role" class="form-control {{$errors->has("role") ? 'is-invalid' : (  strlen($role)>0 ? 'is-valid':'')}}" value="{{$role->display_name}}" disabled>
        </div>
    </div>
    <div class="form-group">
        @if(strcmp($submit_btn_title, 'Update')==0)
            <a class="btn btn-default" type="button" data-dismiss="modal" wire:click="resetInputFields">Cancel</a>
        @endif
        <button type="submit" class="btn btn-primary float-right">{{$submit_btn_title}}</button>
    </div>
</form>



