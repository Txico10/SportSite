<div>
    <div class="pb-2">
      <button class="btn btn-sm btn-outline-primary" type="button" data-toggle="modal" data-target="#modal-contact">
        <i class="fas fa-plus"></i> 
        Add contact
      </button>
    </div>
    <div class="card card">
      @if(isset($contacts))
      <div class="card-body pb-0">
          <div class="row d-flex align-items-stretch">
              @forelse($contacts as $contact)
              <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                <div class="card bg-light">
                  <div class="card-header text-muted border-bottom-0">
                    {{ucfirst($contact->type)}} contact 
                  </div>
                  <div class="card-body pt-0">
                    <div class="row">
                      <div class="col-12">
                        @if(!empty($contact->name))
                        <h2 class="lead"><b>{{$contact->name}}</b></h2>
                        @else
                        <h2 class="lead"><b>{{auth()->user()->name}}</b></h2>
                        @endif
                        <p class="text-muted text-sm"><b>Relationship: </b> {{empty($contact->relationship)? 'N/A' : $contact->relationship}} </p>
                        <ul class="ml-4 mb-2 fa-ul text-muted">
                          <li class="medium"><span class="fa-li"><i class="fas fa-home"></i></span> {{empty($contact->suite)? '' :$contact->suite." -"}}  {{empty($contact->num)? '' :$contact->num}}
                              {{empty($contact->street)? 'N/A' :$contact->street.", "}} {{empty($contact->city)? '' :$contact->city.", "}} {{empty($contact->region)? '' :$contact->region}}
                              {{empty($contact->pc)? '' :$contact->pc}} {{empty($contact->country)? '' :$contact->country}}</li>
                          <li class="medium"><span class="fa-li"><i class="fas fa-phone-alt"></i></span> {{empty($contact->telephone)? 'N/A':$contact->telephone}}</li>
                          <li class="medium"><span class="fa-li"><i class="fas fa-mobile-alt"></i></span> {{empty($contact->mobile)? 'N/A':$contact->mobile}}</li>
                          <li class="medium"><span class="fa-li"><i class="fas fa-at"></i></span> {{empty($contact->email)? 'N/A':$contact->email}}</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="text-right">
                      @if(strcmp($contact->type,"primary")!=0)
                      <button class="btn btn-sm btn-outline-info" type="button" wire:click="$emit('editContact',{{$contact->id}})"><i class="fas fa-pencil-alt"></i> Edit</button>
                      <button class="btn btn-sm btn-outline-danger" type="button" wire:click="$emit('triggerDeleteContact',{{$contact->id}})"><i class="fas fa-trash-alt"></i> Delete</button>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              @empty
                <p>Pas daddress</p>
              @endforelse
              
          </div>
      </div>
      <!-- /.card-body -->
      @endif
    </div>
</div>