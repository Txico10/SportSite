
      <div class="card" id="myclient-form">
        <div class="card-body p-0">
          <div class="bs-stepper linear">
            <div class="bs-stepper-header" role="tablist">
              <!-- your steps here -->
              <div class="step {{$currentStep == 1 ? 'active':'' }}" data-target="#company-part">
                <button type="button" class="step-trigger" role="tab" aria-controls="company-part" id="company-part-trigger" aria-selected="{{$currentStep == 1 ? 'true':'false' }}" disabled = "{{$currentStep == 1 ? 'true':'false'}}">
                  <span class="bs-stepper-circle">
                    <span class="fas fa-building" aria-hidden="true"></span>
                  </span>
                  <span class="bs-stepper-label">Company</span>
                </button>
              </div>
              <div class="line"></div>
              <div class="step {{$currentStep == 2 ? 'active':'' }}" data-target="#adress-part">
                <button type="button" class="step-trigger" role="tab" aria-controls="adress-part" id="adress-part-trigger" aria-selected="{{$currentStep == 2 ? 'true':'false'}}" disabled="{{$currentStep == 2 ? 'true':'false'}}">
                  <span class="bs-stepper-circle">
                    <span class="fas fa-map-marked" aria-hidden="true"></span>
                  </span>
                  <span class="bs-stepper-label">Address</span>
                </button>
              </div>
              <div class="line"></div>
              <div class="step {{$currentStep == 3 ? 'active':'' }}" data-target="#manager-part">
                <button type="button" class="step-trigger" role="tab" aria-controls="manager-part" id="managet-part-trigger" aria-selected="{{$currentStep == 3 ? 'true':'false'}}" disabled="{{$currentStep == 3 ? 'true':'false'}}">
                  <span class="bs-stepper-circle">
                    <span class="fas fa-user" aria-hidden="true"></span>
                  </span>
                  <span class="bs-stepper-label">Account</span>
                </button>
              </div>
              <div class="line"></div>
              <div class="step {{$currentStep == 4 ? 'active':'' }}" data-target="#thankyou-part">
                <button type="button" class="step-trigger" role="tab" aria-controls="thankyou-part" id="thankyou-part-trigger" aria-selected="{{$currentStep == 4 ? 'true':'false'}}" disabled="{{$currentStep == 4 ? 'true':'false'}}">
                  <span class="bs-stepper-circle">
                    <span class="fas fa-save" aria-hidden="true"></span>
                  </span>
                  <span class="bs-stepper-label">Save</span>
                </button>
              </div>
            </div>
            <div class="bs-stepper-content">
              <!-- your steps content here -->
              <div id="company-part" class="content {{$currentStep == 1 ? 'active dstepper-block':''}}" role="tabpanel" aria-labelledby="company-part-trigger">
                <!-- Companies registration form-->
                <!-- Companies logo -->
                <div class="form-group">
                  <div class="input-group pb-3">
                      @if(!empty($logo))
                          <img class="profile-user-img img-fluid img-circle" src="{{$logo->temporaryUrl()}}" alt="Company profile picture">
                      @else
                          <img class="profile-user-img img-fluid img-circle" src="https://picsum.photos/128/128" alt="Company profile picture">
                      @endif
                  </div>
                  @error('logo')
                      <label for="name" class="text-danger">{{ $message }}</label>
                  @enderror
                  <div class="input-group">
                      <div class="custom-file">
                          <input type="file" class="custom-file-input" id="logo" wire:model="logo">
                          <label class="custom-file-label" for="logo">Choose company logo</label>
                      </div>
                  </div>
                </div>
                <!-- Companies name -->
                <div class="form-group">
                  @error('name')
                      <label for="name" class="text-danger">{{ $message }}</label>
                  @enderror
                  <div class="input-group mb-3">
                      <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-fw fa-building"></i></span>
                      </div>
                      <input type="text" id="name" class="form-control {{$errors->has("name") ? 'is-invalid' : (  strlen($name)>0 ? 'is-valid':'')}}" wire:model.lazy="name" placeholder="Company name">
                  </div>
                </div>
                <!-- Companies NEQ or NAS -->
                <div class="form-group">
                  @error('neq')
                      <label class="text-danger">{{ $message }}</label>
                  @enderror
                  <div class="input-group mb-3">
                      <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-fw fa-fingerprint"></i></span>
                      </div>
                      <input type="text" id="neq" class="form-control {{$errors->has("neq") ? 'is-invalid' : (  strlen($neq)>0 ? 'is-valid':'')}}" wire:ignore placeholder="Company TIN" data-mask>
                  </div>
                </div>
                <!-- Country -->
                <div class="form-group">
                  @error('country')
                    <label class="text-danger">{{ $message }}</label>
                  @enderror
                  <div class="input-group mb-3" wire:ignore>
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-fw fa-globe-americas"></i></span>
                    </div>
                    <select class="form-control" name="country" id="country" data-placeholder="Select Country" data-allow-clear="true" style="width: 93.8%">
                      <option value=""></option>
                      @foreach($countries as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <!-- Companies legal form -->
                <div class="form-group">
                  @error('legalform')
                      <label class="text-danger">{{ $message }}</label>
                  @enderror
                  <div class="input-group mb-3">
                      <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-fw fa-file-contract"></i></span>
                      </div>
                      <select class="form-control" name="legalform" id="legalform" wire:model="legalform" data-placeholder="Company Legal form" data-allow-clear="true" style="width: 93.8%">
                          <option value=""></option>
                          <option value="Sole proprietorship">Sole proprietorship</option>
                          <option value="Business corporation">Business corporation</option>
                          <option value="General partnership">General partnership</option>
                          <option value="Limited partnership">Limited partnership</option>
                          <option value="Cooperative">Cooperative</option>
                      </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <button class="btn btn-primary float-right" type="button" wire:click="myNextStep">Next <i class="fas fa-fw fa-chevron-right"></i></button>
                  </div>
                </div>
              </div>
              <!-- Companies address and contact form tab-->
              <div id="adress-part" class="content {{$currentStep == 2 ? 'active dstepper-block':''}}" role="tabpanel" aria-labelledby="adress-part-trigger">
                <!-- First Row -->
                <div class="row">
                  <!-- Companies Address - Apartment or suite -->
                  <div class="col-sm-6">
                    <div class="form-group">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-fw fa-hashtag"></i></span>
                        </div>
                        <input type="text" id="suite" class="form-control {{$errors->has("suite") ? 'is-invalid' : (  strlen($suite)>0 ? 'is-valid':'')}}" wire:model.lazy="suite" placeholder="Appart">
                      </div>
                      @error('suite')
                        <label class="text-danger">{{ $message }}</label>
                      @enderror
                    </div>
                  </div>
                  <!-- Companies Address - Door number -->
                  <div class="col-sm-6">
                    <div class="form-group">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-fw fa-hashtag"></i></span>
                        </div>
                        <input type="text" id="number" class="form-control {{$errors->has("number") ? 'is-invalid' : (  strlen($number)>0 ? 'is-valid':'')}}" wire:model.lazy="number" placeholder="Building number">
                      </div>
                      @error('number')
                        <label class="text-danger">{{ $message }}</label>
                      @enderror
                    </div>
                  </div>
                </div>
                <!-- Street row-->
                <div class="row">
                  <!-- Companies Address - Street -->
                  <div class="col-sm-12">
                    <div class="form-group">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-fw fa-road"></i></i></span>
                        </div>
                        <input type="text" id="street" class="form-control {{$errors->has("street") ? 'is-invalid' : (  strlen($street)>0 ? 'is-valid':'')}}" wire:model.lazy="street" placeholder="Street">
                      </div>
                      @error('street')
                        <label class="text-danger">{{ $message }}</label>
                      @enderror
                    </div>
                  </div>
                </div>
                <!-- Second Row -->
                <div class="row">
                  <!-- Companies Address - City -->
                  <div class="col-sm-6">
                    <div class="form-group">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-fw fa-city"></i></span>
                        </div>
                        <select class="form-control" name="city" id="city" data-placeholder="Select City" data-allow-clear="true" wire:model="city">
                        <option value=""></option>
                          @if(is_array($countryCities) && count($countryCities)>0)
                            @foreach($countryCities as $key => $value)
                              <option value="{{$key}}">{{utf8_decode($value)}}</option>
                            @endforeach
                          @endif
                        </select>
                      </div>
                      @error('city')
                        <label class="text-danger">{{ $message }}</label>
                      @enderror
                    </div>
                  </div>
                  <!-- Companies Address - Region/Province -->
                  <div class="col-sm-6">
                      <div class="form-group">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-fw fa-map-marker-alt"></i></span>
                          </div>
                          <input type="text" id="region" disabled class="form-control {{$errors->has("region") ? 'is-invalid' : (  strlen($region)>0 ? 'is-valid':'')}}" wire:model.lazy="region" placeholder="Region">
                        </div>
                        @error('region')
                          <label class="text-danger">{{ $message }}</label>
                        @enderror
                      </div>
                  </div>
                </div>
                <!-- Tird row -->
                <div class="row">
                  <!-- Companies Address - Country -->
                  <div class="col-sm-6">
                    <div class="form-group">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-fw fa-globe-americas"></i></span>
                        </div>
                        <input type="text" class="form-control is-valid" value="{{$country}}" disabled>
                      </div>
                    </div>
                  </div>
                  <!-- Companies Address - Zip/Postal code -->
                  <div class="col-sm-6">
                    <div class="form-group">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-fw fa-map-marked"></i></span>
                        </div>
                        <input type="text" id="zip" class="form-control {{$errors->has("zip") ? 'is-invalid' : (  strlen($zip)>0 ? 'is-valid':'')}}" wire:ignore placeholder="ZIP Code">
                      </div>
                      @error('zip')
                        <label class="text-danger">{{ $message }}</label>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-primary" type="button" wire:click="myPreviousStep"><i class="fas fa-fw fa-chevron-left"></i> Previous</button>
                        <button class="btn btn-primary float-right" type="button" wire:click="myNextStep">Next <i class="fas fa-fw fa-chevron-right"></i></button>
                    </div>
                </div>
              </div>
              <!-- Administrator tab -->
              <div id="manager-part" class="content {{$currentStep == 3 ? 'active dstepper-block':''}}" role="tabpanel" aria-labelledby="manager-part-trigger">
                <div class="row">
                  <!-- First column -->
                  <div class="col-sm-6">
                    <!-- Manager name -->
                    <div class="form-group">
                      @error('managerName')
                          <label for="name" class="text-danger">{{ $message }}</label>
                      @enderror
                      <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-fw fa-user"></i></span>
                          </div>
                          <input type="text" id="managerName" wire:model.lazy="managerName" class="form-control {{$errors->has("managerName") ? 'is-invalid' : (  strlen($managerName)>0 ? 'is-valid':'')}}" placeholder="Administrator name">
                      </div>
                    </div>
                    <!-- Manager birthdate -->
                    <div class="form-group">
                        @error('managerBirth')
                            <label for="name" class="text-danger">{{ $message }}</label>
                        @enderror
                        <div class="input-group table-auto mb-3 date" id="managerBirth" data-target-input="nearest" wire:ignore>
                            <div class="input-group-prepend" data-target="#managerBirth" data-toggle="datetimepicker">
                                <span class="input-group-text"><i class="fas fa-fw fa-calendar-check"></i></span>
                            </div>
                            <input type="text" class="form-control datetimepicker-input managerBirth {{$errors->has('managerBirth') ? 'is-invalid' : (strlen($managerBirth)>0 ? 'is-valid':'')}}" placeholder="Administrator Birthdate" data-target="#managerBirth" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                        </div>
                    </div>
                    <!-- Manager Gender -->
                    <div class="form-group">
                      @error('managerGender')
                        <label class="text-danger">{{ $message }}</label>
                      @enderror
                      <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-fw fa-venus-mars"></i></span>
                          </div>
                          <select class="form-control" name="managerGender" id="managerGender" wire:model="managerGender" data-placeholder="Administrator gender" style="width: 87.3%">
                              <option value=""></option>
                              <option value="M">Male</option>
                              <option value="F">Female</option>
                          </select>
                      </div>
                    </div>
                    <!-- Manager mobile phone number -->
                    <div class="form-group">
                      @error('managerMobile')
                        <label class="text-danger">{{ $message }}</label>
                      @enderror
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-fw fa-mobile-alt"></i></span>
                        </div>
                        <input type="text" id="managerMobile" wire:ignore class="form-control {{$errors->has("managerMobile") ? 'is-invalid' : (  strlen($managerMobile)>0 ? 'is-valid':'')}}" placeholder="Mobile number">
                      </div>
                    </div>
                  </div>
                  <!-- Second column - User account -->
                  <div class="col-sm-6">
                    <!-- Manager email -->
                    <div class="form-group">
                      @error('managerEmail')
                          <label class="text-danger">{{ $message }}</label>
                      @enderror
                      <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-fw fa-at"></i></span>
                          </div>
                          <input type="email" id="managerEmail" wire:model.lazy="managerEmail" class="form-control {{$errors->has("managerEmail") ? 'is-invalid' : (strlen($managerEmail)>0 ? 'is-valid':'')}}" placeholder="Enter email">
                      </div>
                    </div>
                    <!-- Manager Password -->
                    <div class="form-group">
                      @error('managerPassword')
                          <label class="text-danger">{{ $message }}</label>
                      @enderror
                      <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-fw fa-key"></i></span>
                          </div>
                          <input type="password" id="managerPassword" class="form-control {{$errors->has("managerPassword") ? 'is-invalid' : (strlen($managerPassword)>0 ? 'is-valid':'')}}" wire:model.lazy="managerPassword" placeholder="Password">
                      </div>
                    </div>
                    <!-- Manager confirm password -->
                    <div class="form-group">
                      @error('managerConfirmPassword')
                          <label class="text-danger">{{ $message }}</label>
                      @enderror
                      <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-fw fa-key"></i></span>
                          </div>
                          <input type="password" id="managerConfirmPassword" class="form-control {{$errors->has("managerConfirmPassword") ? 'is-invalid' : (strlen($managerConfirmPassword)>0 ? 'is-valid':'')}}" wire:model.lazy="managerConfirmPassword" placeholder="Retype Password">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <button class="btn btn-primary" type="button" wire:click="myPreviousStep"><i class="fas fa-fw fa-chevron-left"></i> Previous</button>
                        <button class="btn btn-primary float-right" type="button" wire:click="myNextStep">Next <i class="fas fa-fw fa-chevron-right"></i></button>
                    </div>
                  </div>
              </div>
              <!-- Thank you page-->
              <div id="thankyou-part" class="content {{$currentStep == 4 ? 'active dstepper-block':''}}" role="tabpanel" aria-labelledby="thankyou-part-trigger">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Company</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Address</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Account</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                <dl class="row">
                                    <dt class="col-sm-4">Logo</dt>
                                    <dd class="col-sm-8"><img class="profile-user-img img-fluid img-circle" src="{{!empty($logo) ? $logo->temporaryUrl() : 'https://picsum.photos/128/128'}}" alt="My Logo"></dd>
                                    <dt class="col-sm-4">Name</dt>
                                    <dd class="col-sm-8">{{$name}}</dd>
                                    <dt class="col-sm-4">TIN</dt>
                                    <dd class="col-sm-8">{{$neq}}</dd>
                                    <dt class="col-sm-4">Legal form</dt>
                                    <dd class="col-sm-8">{{$legalform}}</dd>
                                </dl>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
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
                            <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                                <dl class="row">
                                    <dt class="col-sm-4">Name</dt>
                                    <dd class="col-sm-8">{{$managerName}}</dd>
                                    <dt class="col-sm-4">Birthdate</dt>
                                    <dd class="col-sm-8">{{$managerBirth}}</dd>
                                    <dt class="col-sm-4">Gender</dt>
                                    <dd class="col-sm-8">{{empty($managerGender)?"":($managerGender==="F"?"Female":"Male")}}</dd>
                                    <dt class="col-sm-4">Mobile</dt>
                                    <dd class="col-sm-8">{{$managerMobile}}</dd>
                                    <dt class="col-sm-4">Username / Email</dt>
                                    <dd class="col-sm-8">{{$managerEmail}}</dd>
                                    <dt class="col-sm-4">Password</dt>
                                    <dd class="col-sm-8">
                                          <span class="text-info">*********</span>
                                          <span><a href="javascript:void(0);" id="showpasswd"><i class="far fa-eye toggle-password"></i></a></span>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-primary" type="button" wire:click="myPreviousStep"><i class="fas fa-fw fa-chevron-left"></i> Previous</button>
                        <button type="submit" class="btn btn-primary float-right" style="width: 15%" wire:click="submitForm"><i class="fas fa-fw fa-save"></i> Save</button>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.card -->

