<div class="row" id="myEmployeeForm">
   <div class="col-md-12">
      <div class="card card-default">
        <div class="card-body p-0">
          <div class="bs-stepper linear">
            <div class="bs-stepper-header" role="tablist">
              <!-- your steps here -->
              <div class="step {{$currentStep == 1 ? 'active':'' }}" data-target="#employee-part">
                <button type="button" class="step-trigger" role="tab" aria-controls="employee-part" id="employee-part-trigger" aria-selected="{{$currentStep == 1 ? 'true':'false' }}" {{$currentStep != 1 ? 'disabled=disabled':''}}>
                  <span class="bs-stepper-circle">
                    <span class="fas fa-user-tie" aria-hidden="true"></span>
                  </span>
                  <span class="bs-stepper-label">Employee</span>
                </button>
              </div>
              <div class="line"></div>
              <div class="step {{$currentStep == 2 ? 'active':'' }}" data-target="#adress-part">
                <button type="button" class="step-trigger" role="tab" aria-controls="adress-part" id="adress-part-trigger" aria-selected="{{$currentStep == 2 ? 'true':'false'}}" {{$currentStep != 2 ? 'disabled=disabled':''}}>
                  <span class="bs-stepper-circle">
                    <span class="fas fa-map-marked" aria-hidden="true"></span>
                  </span>
                  <span class="bs-stepper-label">Address</span>
                </button>
              </div>
              <div class="line"></div>
              <div class="step {{$currentStep == 3 ? 'active':'' }}" data-target="#user-part">
                <button type="button" class="step-trigger" role="tab" aria-controls="user-part" id="user-part-trigger" aria-selected="{{$currentStep == 3 ? 'true':'false'}}" {{$currentStep != 3 ? 'disabled=disabled':''}}>
                  <span class="bs-stepper-circle">
                    <span class="fas fa-user-cog" aria-hidden="true"></span>
                  </span>
                  <span class="bs-stepper-label">Account</span>
                </button>
              </div>
              <div class="line"></div>
              <div class="step {{$currentStep == 4 ? 'active':'' }}" data-target="#contract-part">
                <button type="button" class="step-trigger" role="tab" aria-controls="contract-part" id="contract-part-trigger" aria-selected="{{$currentStep == 4 ? 'true':'false'}}" {{$currentStep != 4 ? 'disabled=disabled':''}}>
                  <span class="bs-stepper-circle">
                    <span class="fas fa-file-signature" aria-hidden="true"></span>
                  </span>
                  <span class="bs-stepper-label">Save</span>
                </button>
              </div>
            </div>
            <div class="bs-stepper-content">
              <!-- your steps content here -->
              <div id="employee-part" class="bs-stepper-pane {{$currentStep == 1 ? 'active dstepper-block':''}}" role="tabpanel" aria-labelledby="employee-part-trigger">
                <!-- Employee registration form-->
                <!-- Employee photo -->
                <div class="form-group">
                  <div class="input-group pb-3">
                      @if(!empty($photo))
                          <img class="profile-user-img img-fluid img-circle" src="{{$photo->temporaryUrl()}}" alt="Employee profile picture">
                      @else
                          <img class="profile-user-img img-fluid img-circle" src="https://picsum.photos/128/128" alt="Employee profile picture">
                      @endif
                  </div>
                  @error('photo')
                      <label for="name" class="text-danger">{{ $message }}</label>
                  @enderror
                  <div class="input-group">
                      <div class="custom-file">
                          <input type="file" class="custom-file-input" id="photo" wire:model="photo">
                          <label class="custom-file-label" for="photo">Choose Employee photo</label>
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
                          <span class="input-group-text"><i class="fas fa-user"></i></span>
                      </div>
                      <input type="text" id="name" class="form-control {{$errors->has("name") ? 'is-invalid' : (  strlen($name)>0 ? 'is-valid':'')}}" wire:model.lazy="name" placeholder="Employee name">
                  </div>
                </div>
                <!-- Manager birthdate -->
                <div class="form-group">
                  @error('birthdate')
                    <label for="name" class="text-danger">{{ $message }}</label>
                  @enderror
                  <div class="input-group mb-3 date" id="employee-birthdate" data-target-input="nearest" wire:ignore>
                    <div class="input-group-prepend" data-target="#employee-birthdate" data-toggle="datetimepicker">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control datetimepicker-input employee-birthdate {{$errors->has("birthdate") ? 'is-invalid' : (strlen($birthdate)>0 ? 'is-valid':'')}}" placeholder="Employee Birthdate" data-target="#employee-birthdate" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
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
                    <select class="form-control" name="gender" id="employeeGender" data-placeholder="Select gender" data-allow-clear="true" style="width: 94.0%" wire:model="gender">
                      <option value=""></option>
                      <option value="M">Male</option>
                      <option value="F">Female</option>
                      <option value="O">Other</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <button class="btn btn-primary float-right" type="button" wire:click="myNextStep">Next</button>
                  </div>
                </div>
              </div>
              <!-- Employee address and contact form tab-->
              <div id="adress-part" class="bs-stepper-pane {{$currentStep == 2 ? 'active dstepper-block':''}}" role="tabpanel" aria-labelledby="adress-part-trigger">
                <!-- First Row -->
                <div class="row">
                  <!-- Companies Address - Apartment or suite -->
                  <div class="col-sm-6">
                    <div class="form-group">
                      @error('suite')
                        <label class="text-danger">{{ $message }}</label>
                      @enderror
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-map"></i></span>
                        </div>
                        <input type="text" id="suite" class="form-control {{$errors->has("suite") ? 'is-invalid' : (  strlen($suite)>0 ? 'is-valid':'')}}" wire:model.lazy="suite" placeholder="Appart">
                      </div>
                    </div>            
                  </div>
                  <!-- Companies Address - Dor number -->
                  <div class="col-sm-6">
                    <div class="form-group">
                      @error('number')
                        <label class="text-danger">{{ $message }}</label>
                      @enderror
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-map"></i></span>
                        </div>
                        <input type="text" id="number" class="form-control {{$errors->has("number") ? 'is-invalid' : (  strlen($number)>0 ? 'is-valid':'')}}" wire:model.lazy="number" placeholder="Number">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Street row-->
                <div class="row">
                  <!-- Companies Address - Street -->
                  <div class="col-sm-12">
                    <div class="form-group">
                      @error('street')
                        <label class="text-danger">{{ $message }}</label>
                      @enderror
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-road"></i></i></span>
                        </div>
                        <input type="text" id="street" class="form-control {{$errors->has("street") ? 'is-invalid' : (  strlen($street)>0 ? 'is-valid':'')}}" wire:model.lazy="street" placeholder="Street">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Second Row -->
                <div class="row">
                  <!-- Companies Address - City -->
                  <div class="col-sm-6">
                    <div class="form-group">
                      @error('city')
                        <label class="text-danger">{{ $message }}</label>
                      @enderror
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-map"></i></span>
                        </div>
                        <select class="form-control" name="employee-city" id="employee-city" data-placeholder="Select City" data-allow-clear="true" wire:model="city">
                          <option value=""></option>
                          @if(is_array($countryCities) && count($countryCities)>0)
                            @foreach($countryCities as $key => $value)
                              <option value="{{$key}}">{{utf8_decode($value)}}</option>
                            @endforeach
                          @endif
                        </select>
                      </div>
                    </div>
                  </div>
                  <!-- Employee Address - Region/Province -->
                  <div class="col-sm-6">
                      <div class="form-group">
                        @error('region')
                          <label class="text-danger">{{ $message }}</label>
                        @enderror
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-map"></i></span>
                          </div>
                          <input type="text" id="employee-region" class="form-control {{$errors->has("region") ? 'is-invalid' : (  strlen($region)>0 ? 'is-valid':'')}}" wire:model="region" placeholder="Region" disabled>
                        </div>
                      </div>
                  </div>
                </div>
                <!-- Tird row -->
                <div class="row">
                  <!-- Companies Address - Country -->
                  <div class="col-sm-6">
                  <!-- Employee Country -->
                  <div class="form-group">
                    @error('country')
                      <label class="text-danger">{{ $message }}</label>
                    @enderror
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-globe-americas"></i></span>
                      </div>
                      <select class="form-control" name="country" id="employeeCountry" data-placeholder="Select country" data-allow-clear="true">
                        <option value=""></option>
                        @foreach($countries as $key => $newCountry)
                          @if(strcmp($key, $country)==0)
                            <option value="{{$key}}" selected>{{$newCountry}}</option>
                          @else
                            <option value="{{$key}}">{{$newCountry}}</option>  
                          @endif
                        @endforeach
                      </select>
                    </div>
                  </div>  
                  </div>
                  <!-- Companies Address - Zip/Postal code -->
                  <div class="col-sm-6">
                    <div class="form-group">
                      @error('zip')
                        <label class="text-danger">{{ $message }}</label>
                      @enderror
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-map"></i></span>
                        </div>
                        <input type="text" id="employee-zip" class="form-control {{$errors->has("zip") ? 'is-invalid' : (  strlen($zip)>0 ? 'is-valid':'')}}" wire:ignore placeholder="ZIP Code">
                      </div>
                    </div>
                  </div>
                </div>
                <button class="btn btn-primary" type="button" wire:click="myPreviousStep">Previous</button>
                <button class="btn btn-primary float-right" type="button" wire:click="myNextStep">Next</button>
              </div>
              <!-- User tab -->
              <div id="user-part" class="bs-stepper-pane {{$currentStep == 3 ? 'active dstepper-block':''}}" role="tabpanel" aria-labelledby="user-part-trigger">
                <div class="row">
                  <!-- First column -->
                  <div class="col-sm-6">
                    <!-- Manager mobile phone number -->
                    <div class="form-group">
                      @error('mobile')
                        <label class="text-danger">{{ $message }}</label>
                      @enderror
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                        </div>
                        <input type="text" id="employee-mobile" class="form-control {{$errors->has("mobile") ? 'is-invalid' : (  strlen($mobile)>0 ? 'is-valid':'')}}" wire:ignore placeholder="Mobile number">
                      </div>
                    </div>
                    <!-- Manager email -->
                    <div class="form-group">
                      @error('email')
                          <label class="text-danger">{{ $message }}</label>
                      @enderror
                      <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-at"></i></span>
                          </div>
                          <input type="email" id="email" wire:model.lazy="email" class="form-control {{$errors->has("email") ? 'is-invalid' : (strlen($email)>0 ? 'is-valid':'')}}" placeholder="Enter email">
                      </div>
                    </div>
                    <!-- Manager Password -->
                    <div class="form-group">
                      @error('password')
                          <label class="text-danger">{{ $message }}</label>
                      @enderror
                      <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-key"></i></span>
                          </div>
                          <input type="password" id="password" class="form-control {{$errors->has("password") ? 'is-invalid' : (strlen($password)>0 ? 'is-valid':'')}}" wire:model.lazy="password" placeholder="Password">
                      </div>
                    </div>
                    <!-- Manager confirm password -->
                    <div class="form-group">
                      @error('confirmPassword')
                          <label class="text-danger">{{ $message }}</label>
                      @enderror
                      <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-key"></i></span>
                          </div>
                          <input type="password" id="confirmPassword" class="form-control {{$errors->has("confirmPassword") ? 'is-invalid' : (strlen($confirmPassword)>0 ? 'is-valid':'')}}" wire:model.lazy="confirmPassword" placeholder="Retype Password">
                      </div>
                    </div>
                  </div>                  
                  <!-- Second column - User account -->
                  <div class="col-sm-6">
                    <!-- Employee role -->
                    <div class="form-group">
                      @error('role')
                        <label class="text-danger">{{ $message }}</label>
                      @enderror
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                        </div>
                        <select class="form-control" name="role" id="employee-role" data-placeholder="Select Role" data-allow-clear="true" wire:model="role">
                          <option value=""></option>
                          @foreach($roles as $key => $newRole)
                            <option value="{{$newRole->id}}">{{ucfirst($newRole->name)}}</option>  
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <!-- Employee start date-->
                    <div class="form-group">
                      @error('startDate')
                        <label for="name" class="text-danger">{{ $message }}</label>
                      @enderror
                      <div class="input-group mb-3 date" id="employee-startDate" data-target-input="nearest" wire:ignore>
                        <div class="input-group-prepend" data-target="#employee-startDate" data-toggle="datetimepicker">
                          <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                        </div>
                        <input type="text" class="form-control datetimepicker-input employee-start" placeholder="Contract start date" data-target="#employee-startDate" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy HH:MM" data-mask>
                      </div>
                    </div>
                    <!-- Employee end date -->
                    <div class="form-group">
                      @error('endDate')
                        <label for="name" class="text-danger">{{ $message }}</label>
                      @enderror
                      <div class="input-group mb-3 date" id="employee-endDate" data-target-input="nearest" wire:ignore style='display:none'>
                        <div class="input-group-prepend" data-target="#employee-endDate" data-toggle="datetimepicker">
                          <span class="input-group-text"><i class="fas fa-calendar-times"></i></span>
                        </div>
                        <input type="text" class="form-control datetimepicker-input employee-endDate" placeholder="Contract end date" data-target="#employee-endDate" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy HH:MM" data-mask>
                      </div>
                    </div>
                    <!-- CheckBox -->
                    <div class="form-group">
                      <div class="icheck-primary">
                        <input type="checkbox" name="tcontract" id="tcontract" value="{{$tcontract}}" {{$tcontract==1 ?'checked' : ''}}>
                        <label class="text-info" for="tcontract">Have a permanent position</label>
                      </div>
                    </div>

                  </div>
                </div>
                <button class="btn btn-primary" type="button" wire:click="myPreviousStep">Previous</button>
                <button class="btn btn-primary float-right" type="button" wire:click="myNextStep"">Next</button>
              </div>
              <!-- Thank you page-->
              <div id="contract-part" class="bs-stepper-pane {{$currentStep == 4 ? 'active dstepper-block':''}}" role="tabpanel" aria-labelledby="contract-part-trigger">
                <!-- Company Card -->
                <div class="card card-lightblue card-outline">
                  <div class="card-header">
                    <h3 class="card-title">
                      <i class="fas fa-building"></i>
                      Employee
                    </h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <dl class="row">
                      <dt class="col-sm-4">Photo</dt>
                      <dd class="col-sm-8"><img class="profile-user-img img-fluid img-circle" src="{{!empty($logo) ? $logo->temporaryUrl() : 'https://picsum.photos/128/128'}}" alt="My Logo"></dd>
                      <dt class="col-sm-4">Name</dt>
                      <dd class="col-sm-8">{{$name}}</dd>
                      <dt class="col-sm-4">Birthdate</dt>
                      <dd class="col-sm-8">{{\Carbon\Carbon::parse($birthdate)->format("d-m-Y")}}</dd>
                      <dt class="col-sm-4">Gender</dt>
                      <dd class="col-sm-8">{{$gender==="M"? "Male" : ($gender==="F"?"Female":"Other")}}</dd>
                    </dl>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.company card -->
                <!-- Company Address --> 
                <div class="card card-lightblue card-outline">
                  <div class="card-header">
                    <h3 class="card-title">
                      <i class="fas fa-map-marked"></i>
                      Address
                    </h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <dl class="row">
                      <dt class="col-sm-4">Default</dt>
                      @if(!empty($suite))
                      <dd class="col-sm-8">#{{$suite}} - {{$number}}, {{$street}}</dd>
                      @else
                      <dd class="col-sm-8">{{$number}}, {{$street}}</dd>
                      @endif
                      @if(!empty($region))
                      <dd class="col-sm-8 offset-sm-4">{{$city}}, {{$region}}</dd>  
                      @else
                      <dd class="col-sm-8 offset-sm-4">{{$city}} </dd>  
                      @endif
                      @if(!empty($zip))
                      <dd class="col-sm-8 offset-sm-4">{{$country}}, {{$zip}}</dd>  
                      @else
                      <dd class="col-sm-8 offset-sm-4">{{$country}}</dd>  
                      @endif
                    </dl>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <!-- Company Account -->
                <div class="card card-lightblue card-outline">
                  <div class="card-header">
                    <h3 class="card-title">
                      <i class="fas fa-user"></i>
                      Account
                    </h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <dl class="row">
                      <dt class="col-sm-4">Role</dt>
                      <dd class="col-sm-8">{{ucfirst($roles->where('id', $role)->first()->name ?? null)}}</dd>
                      <dt class="col-sm-4">Start date</dt>
                      <dd class="col-sm-8">{{\Carbon\Carbon::parse($startDate)->format("d-m-Y")}}</dd>
                      @if($tcontract==0)
                      <dt class="col-sm-4">End Date</dt>
                      <dd class="col-sm-8">{{\Carbon\Carbon::parse($endDate)->format("d-m-Y")}}</dd>
                      @endif
                      <dt class="col-sm-4">Mobile</dt>
                      <dd class="col-sm-8">{{$mobile}}</dd>
                      <dt class="col-sm-4">Username / Email</dt>
                      <dd class="col-sm-8">{{$email}}</dd>
                      <dt class="col-sm-4">Password</dt>
                      <dd class="col-sm-8">
                            <span class="text-info passwd-txt">*********</span>
                            <span><a href="javascript:void(0);" id="showpasswd"><i class="far fa-eye toggle-password"></i></a></span>
                      </dd>
                    </dl>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <button class="btn btn-primary" type="button" wire:click="myPreviousStep">Previous</button>
                <button type="submit" class="btn btn-primary float-right" wire:click="submitForm">Submit</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.card -->
   </div>
   <!-- /.col-md-12 -->
</div>
