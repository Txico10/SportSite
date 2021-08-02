<div class="card card-primary card-outline">
  <div class="card-body box-profile">
    <div class="text-center">
      @if(!empty($user->image))
      <img class="profile-user-img img-fluid img-circle" src="{{asset('storage/profile_images/employees/'.$user->image)}}" alt="{{$user->name}}">
      @else
      <img class="profile-user-img img-fluid img-circle" src="https://picsum.photos/128/128" alt="User profile picture">
      @endif
    </div>
    <h3 class="profile-username text-center">{{$user->name}}</h3>
    <p class="text-muted text-center">{{$user->roles->last()->display_name}}</p>
    <ul class="list-group list-group-unbordered mb-3">
      <li class="list-group-item">
        <i class="fas fa-user-check mr-1"></i><b>Status</b> <a class="float-right">{{$user->status?"Active":"Inactive"}}</a>
      </li>
      <li class="list-group-item">
        <i class="fas fa-envelope mr-1"></i><b>Email</b> <a class="float-right">{{$user->email}}</a>
      </li>
      <li class="list-group-item">
        <i class="fas fa-key mr-1"></i><b>Token</b> <a class="float-right">{{Str::limit($user->api_token, 25, '...')}}</a>
      </li>
    </ul>
    <button type="button" class="btn btn-primary btn-block" wire:click="$emit('editProfile')"><b>Edit profile</b></button>
  </div>
  <!-- /.card-body -->
  <x-modal title="My Profile" id="modal-profile" type="" icon="fas fa-user-secret">
    <livewire:user.profile-form :user="$user" />
  </x-modal>
</div>
