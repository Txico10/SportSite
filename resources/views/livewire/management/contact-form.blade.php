<form wire:submit.prevent="saveContactForm" id="contact-form" role="form">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-house-user"></i></i></span>
                            </div>
                            <input type="text" id="suite" class="form-control {{$errors->has("suite") ? 'is-invalid' : (  strlen($suite)>0 ? 'is-valid':'')}}" wire:model.lazy="suite" placeholder="Appart">
                        </div>
                        @error('suite')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>            
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-home"></i></span>
                            </div>
                            <input type="text" id="num" class="form-control {{$errors->has("num") ? 'is-invalid' : (  strlen($num)>0 ? 'is-valid':'')}}" wire:model.lazy="num" placeholder="Number">
                        </div>
                        @error('num')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-road"></i></i></span>
                            </div>
                            <input type="text" id="street" class="form-control {{$errors->has("street") ? 'is-invalid' : (  strlen($street)>0 ? 'is-valid':'')}}" wire:model.lazy="street" placeholder="Street">
                        </div>
                        @error('street')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-map"></i></span>
                            </div>
                            <select class="form-control" name="city" id="contactCity" wire:model="city" style="width: 80.5%" data-placeholder="Select city" data-allow-clear="true">
                                <option value=""></option>
                                @if(!empty($countryCities))
                                    @foreach($countryCities as $key => $newCity)
                                        <option value="{{$key}}">{{utf8_decode($newCity)}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        @error('city')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-map"></i></span>
                            </div>
                            <input type="text" id="region" class="form-control {{$errors->has("region") ? 'is-invalid' : (  strlen($region)>0 ? 'is-valid':'')}}" wire:model.lazy="region" placeholder="Region">
                        </div>
                        @error('region')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-map"></i></span>
                            </div>
                            <select class="form-control" name="country" id="contactCountry" wire:model="country" style="width: 80.5%" data-placeholder="Select country" data-allow-clear="true">
                                <option value=""></option>
                                @foreach($allCountries as $key => $newCountry)
                                    <option value="{{$key}}">{{$newCountry}}</option>  
                                @endforeach
                            </select>
                        </div>
                        @error('country')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-map"></i></span>
                            </div>
                            <input type="text" id="pc" class="form-control {{$errors->has("pc") ? 'is-invalid' : (  strlen($pc)>0 ? 'is-valid':'')}}" wire:model.lazy="pc" placeholder="ZIP Code">
                        </div>
                        @error('pc')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
            </div>
            <hr>
            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                    </div>
                    <input type="text" id="contactTelephone" class="form-control {{$errors->has("telephone") ? 'is-invalid' : (  strlen($telephone)>0 ? 'is-valid':'')}}" wire:ignore placeholder="Phone number">
                </div>
                @error('telephone')
                    <label class="text-danger">{{ $message }}</label>
                @enderror
            </div>

            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-mobile"></i></span>
                    </div>
                    <input type="text" id="contactMobile" class="form-control {{$errors->has("mobile") ? 'is-invalid' : (  strlen($mobile)>0 ? 'is-valid':'')}}" wire:ignore placeholder="Mobile number">
                </div>
                @error('mobile')
                    <label class="text-danger">{{ $message }}</label>
                @enderror
            </div>

            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" id="email" wire:model.lazy="email" class="form-control {{$errors->has("email") ? 'is-invalid' : (strlen($email)>0 ? 'is-valid':'')}}" placeholder="Enter email">
                </div>
                @error('email')
                    <label class="text-danger">{{ $message }}</label>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            @if(strcmp($submit_btn_title, 'update')==0)
                <button class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
            @endif
        </div>
        <div class="col-sm-6">
            <button type="submit" class="btn btn-primary float-right">{{ucfirst($submit_btn_title)}}</button>
        </div>
    </div>
</form>