<form wire:submit.prevent="saveFurnitureForm" id="furniture-form" role="form">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                @error('furnitureList')
                    <label for="name" class="text-danger">{{ $message }}</label>
                @enderror
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-chair"></i></span>
                    </div>
                    <select name="furniture_list" id="furniture_list" style="width: 91%" wire:model="furniture_type_id" data-placeholder="Select appliance or furniture" data-allow-clear="true">
                        @if(!empty($furnitureList))
                            <option value=""></option>
                        @endif
                        @forelse($furnitureList as $key => $list)
                            <option value="{{$key}}">{{ucfirst($list)}}</option>
                        @empty
                            <option value="-1">Empty list</option>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="form-group">
                @error('manufacturer')
                    <label for="name" class="text-danger">{{ $message }}</label>
                @enderror
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-industry"></i></span>
                    </div>
                    <input type="text" id="manufacturer" class="form-control {{$errors->has("manufacturer") ? 'is-invalid' : (  strlen($manufacturer)>0 ? 'is-valid':'')}}" wire:model.lazy="manufacturer" placeholder="Enter the manufacturer">
                </div>
            </div>
            <div class="form-group">
                @error('model')
                    <label for="name" class="text-danger">{{ $message }}</label>
                @enderror
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                    </div>
                    <input type="text" id="appliance_model" class="form-control {{$errors->has("model") ? 'is-invalid' : (  strlen($model)>0 ? 'is-valid':'')}}" wire:model.lazy="model" placeholder="Enter the model">
                </div>
            </div>
            <div class="form-group">
                @error('serial')
                    <label for="name" class="text-danger">{{ $message }}</label>
                @enderror
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                    </div>
                    <input type="text" id="appliance_serial" class="form-control {{$errors->has("serial") ? 'is-invalid' : (  strlen($serial)>0 ? 'is-valid':'')}}" wire:model.lazy="serial" placeholder="Enter the serial number">
                </div>
            </div>
            <div class="form-group">
                @error('buy_at')
                  <label for="name" class="text-danger">{{ $message }}</label>
                @enderror
                <div class="input-group mb-3 date" id="furniture-aquisition-date" data-target-input="nearest" wire:ignore>
                  <div class="input-group-prepend" data-target="#furniture-aquisition-date" data-toggle="datetimepicker">
                    <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                  </div>
                  <input type="text" class="form-control datetimepicker-input furniture-aquisition {{$errors->has("buy_at") ? 'is-invalid' : (strlen($buy_at)>0 ? 'is-valid':'')}}" placeholder="Aquisition date" data-target="#furniture-aquisition-date" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                </div>
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