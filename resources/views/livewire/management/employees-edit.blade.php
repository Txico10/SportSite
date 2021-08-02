<form wire:submit.prevent="saveEmployeeEdit" id="employee-edit-form" role="form">
    <div class="row">
        <div class="col-sm-12">
            <!-- Employee photo -->
            <div class="form-group">
                <div class="input-group pb-3">
                    @if(!empty($image))
                        <img class="profile-user-img img-fluid img-circle" src="{{ ($image===$old_image) ? asset('storage/profile_images/employees/'.$image) : $image->temporaryUrl()}}" alt="User profile picture">
                    @else
                        <img class="profile-user-img img-fluid img-circle" src="https://picsum.photos/128/128" alt="Employee profile picture">
                    @endif
                </div>
                @error('image')
                    <label for="name" class="text-danger">{{ $message }}</label>
                @enderror
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" wire:model="image">
                        <label class="custom-file-label" for="image">Choose Employee photo</label>
                    </div>
                </div>
              </div>
              <!-- Employee name -->
              <div class="form-group">
                @error('name')
                    <label for="name" class="text-danger">{{ $message }}</label>
                @enderror
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-fw fa-user"></i></span>
                    </div>
                    <input type="text" id="name" class="form-control {{$errors->has("name") ? 'is-invalid' : (  strlen($name)>0 ? 'is-valid':'')}}" wire:model.lazy="name" placeholder="Employee name">
                </div>
              </div>
              <!-- Manager birthdate -->
              <div class="form-group">
                @error('birthdate')
                  <label for="name" class="text-danger">{{ $message }}</label>
                @enderror
                <div class="input-group mb-3 date" id="edit-employee-birthdate" data-target-input="nearest" wire:ignore>
                  <div class="input-group-prepend" data-target="#edit-employee-birthdate" data-toggle="datetimepicker">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                  </div>
                  <input type="text" class="form-control datetimepicker-input edit-employee-birth {{$errors->has("birthdate") ? 'is-invalid' : (strlen($birthdate)>0 ? 'is-valid':'')}}" placeholder="Employee Birthdate" data-target="#edit-employee-birthdate" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                </div>
              </div>
              <!-- Employee NAS -->
              <div class="form-group">
                @error('nas')
                    <label for="name" class="text-danger">{{ $message }}</label>
                @enderror
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-fw fa-hashtag"></i></span>
                    </div>
                    <input type="text" id="name" class="form-control {{$errors->has("nas") ? 'is-invalid' : (  strlen($nas)>0 ? 'is-valid':'')}}" wire:model.lazy="nas" placeholder="Employee NAS">
                </div>
              </div>
              <!-- Employee gender -->
              <div class="form-group">
                @error('gender')
                  <label class="text-danger">{{ $message }}</label>
                @enderror
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                  </div>
                  <select class="form-control" name="employeegender" id="editEmployeeGender" data-placeholder="Select gender" data-allow-clear="true" style="width: 90.0%" wire:model="gender">
                    <option value=""></option>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                    <option value="O">Other</option>
                  </select>
                </div>
              </div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary float-right">Save</button>
    </div>
</form>
