<form wire:submit.prevent="saveForm" id="userform">
    <div class="form-group">
        <div class="input-group pb-3">
            @if(!empty($photo))
                <img class="profile-user-img img-fluid img-circle" src="{{ ($photo===$old_photo) ? asset('storage/profile_images/'.$photo) : $photo->temporaryUrl()}}" alt="User profile picture">
            @else
                <img class="profile-user-img img-fluid img-circle" src="https://picsum.photos/128/128" alt="User profile picture">
            @endif
        </div>
        <div wire:loading wire:target="photo">Uploading...</div>
        <div class="input-group">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="photo" wire:model="photo">
                <label class="custom-file-label" for="photo">Choose file</label>
            </div>
        </div>
        @error('photo')
            <label for="name" class="text-danger">{{ $message }}</label>
        @enderror
    </div>
    <div class="form-group">
        @error('name')
            <label for="name" class="text-danger">{{ $message }}</label>
        @enderror
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input type="text" id="name" class="form-control {{$errors->has("name") ? 'is-invalid' : (  strlen($name)>0 ? 'is-valid':'')}}" wire:model="name" placeholder="Enter name">
            @if(strcmp($submit_btn_title,"Update")==0)
                <input type="hidden" wire:model="user_id" >
            @endif
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
            <input type="email" id="email" class="form-control {{$errors->has("email") ? 'is-invalid' : (  strlen($email)>0 ? 'is-valid':'')}}" wire:model="email" placeholder="Enter email">
        </div>
    </div>
    @if($email !== auth()->user()->email)
    <div class="form-group">
        @error('password')
            <label class="text-danger">{{ $message }}</label>
        @enderror
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
            </div>
            <input type="password" id="password" class="form-control {{$errors->has("password") ? 'is-invalid' : (  strlen($password)>0 ? 'is-valid':'')}}" wire:model.lazy="password" placeholder="Current password">
        </div>
    </div>    
    @endif
    <div class="form-group">
        @if(strcmp($submit_btn_title, 'update')==0)
            <a class="btn btn-default" type="button" data-dismiss="modal">Cancel</a>
        @endif
        <button type="submit" class="btn btn-primary float-right">{{ucfirst($submit_btn_title)}}</button>
    </div>
</form>

