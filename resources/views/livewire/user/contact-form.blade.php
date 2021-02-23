<form wire:submit.prevent="saveContactForm" id="contact-form" role="form">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label for="type"><i class="fas fa-check"></i> Contact type</label>
                <select class="form-control" id="type" style="width: 100%" data-allow-clear="false" wire:ignore data-placeholder = "Select type">
                    <option value=""></option>
                    <option value="emergency">Emergency</option>
                    <option value="other">Other</option>
                </select>
                @error('type')
                    <label class="text-danger">{{ $message }}</label>
                @enderror
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="name"><i class="fas fa-user"></i> Name</label>
                <input type="text" id="name" class="form-control {{$errors->has("name") ? 'is-invalid' : (  strlen($name)>0 ? 'is-valid':'')}}" wire:model="name" placeholder="Name">
                @error('name')
                    <label class="text-danger">{{ $message }}</label>
                @enderror
                @if(strcmp($submit_btn_title,"update")==0)
                <input type="hidden" wire:model = "contact_id">
                @endif
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="relationship"><i class="far fa-user"></i> Relationship</label>
                <select class="form-control" id="relationship" style="width: 100%" wire:ignore data-allow-clear="false" data-placeholder = "Select relationship">
                    <option value=""></option>
                    <option value="parent">Parent</option>
                    <option value="child">Child</option>
                    <option value="spouse">Spouse</option>
                    <option value="friend">Friend</option>
                    <option value="other">Other</option>
                </select>
                @error('relationship')
                    <label class="text-danger">{{ $message }}</label>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label for="telephone"><i class="fas fa-phone-alt"></i> Telephone</label> 
                <input type="tel" id="telephone" class="form-control {{$errors->has("telephone") ? 'is-invalid' : (  strlen($telephone)>0 ? 'is-valid':'')}}" wire:model="telephone" placeholder="Phone number">
                @error('telephone')
                    <label class="text-danger">{{ $message }}</label>
                @enderror
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="mobile"><i class="fas fa-mobile-alt"></i> Mobile</label> 
                <input type="tel" id="mobile" class="form-control {{$errors->has("mobile") ? 'is-invalid' : (  strlen($mobile)>0 ? 'is-valid':'')}}" wire:model="mobile" placeholder="Mobile number">
                @error('mobile')
                    <label class="text-danger">{{ $message }}</label>
                @enderror
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="email"><i class="far fa-envelope"></i> Email</label> 
                <input type="email" id="email" class="form-control {{$errors->has("email") ? 'is-invalid' : (  strlen($email)>0 ? 'is-valid':'')}}" wire:model="email" placeholder="Email">
                @error('email')
                    <label class="text-danger">{{ $message }}</label>
                @enderror
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-2">
            <div class="form-group">
                <label for="suite"><i class="far fa-map"></i> Suite</label>
                <input type="text" id="suite" class="form-control {{$errors->has("suite") ? 'is-invalid' : (  strlen($suite)>0 ? 'is-valid':'')}}" wire:model="suite" placeholder="Appart">
                @error('suite')
                    <label class="text-danger">{{ $message }}</label>
                @enderror
            </div>            
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label for="num"><i class="far fa-map"></i> Number</label>    
                <input type="text" id="num" class="form-control {{$errors->has("num") ? 'is-invalid' : (  strlen($num)>0 ? 'is-valid':'')}}" wire:model="num" placeholder="Number">
                @error('num')
                    <label class="text-danger">{{ $message }}</label>
                @enderror
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="street"><i class="far fa-map"></i> Street</label> 
                <input type="text" id="street" class="form-control {{$errors->has("street") ? 'is-invalid' : (  strlen($street)>0 ? 'is-valid':'')}}" wire:model="street" placeholder="Street">
                @error('street')
                    <label class="text-danger">{{ $message }}</label>
                @enderror
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="city"><i class="far fa-map"></i> City</label> 
                <input type="text" id="city" class="form-control {{$errors->has("city") ? 'is-invalid' : (  strlen($city)>0 ? 'is-valid':'')}}" wire:model="city" placeholder="City">
                @error('city')
                    <label class="text-danger">{{ $message }}</label>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label for="region"><i class="far fa-map"></i> Region</label> 
                <input type="text" id="region" class="form-control {{$errors->has("region") ? 'is-invalid' : (  strlen($region)>0 ? 'is-valid':'')}}" wire:model="region" placeholder="Region">
                @error('region')
                    <label class="text-danger">{{ $message }}</label>
                @enderror
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="pc"><i class="far fa-map"></i> ZIP Code</label> 
                <input type="text" id="pc" class="form-control {{$errors->has("pc") ? 'is-invalid' : (  strlen($pc)>0 ? 'is-valid':'')}}" wire:model="pc" placeholder="ZIP Code">
                @error('pc')
                    <label class="text-danger">{{ $message }}</label>
                @enderror
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="country"><i class="far fa-map"></i> Country</label> 
                <input type="text" id="country" class="form-control {{$errors->has("country") ? 'is-invalid' : (  strlen($country)>0 ? 'is-valid':'')}}" wire:model="country" placeholder="Country">
                @error('country')
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
