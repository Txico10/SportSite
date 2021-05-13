<div class="card card-primary card-outline">
  <div class="card-body box-profile">
    <div class="text-center">
      <img class="profile-user-img img-fluid img-circle" src="{{$user->image ? asset('storage/profile_images/'.$user->image) : 'https://picsum.photos/128/128'}}" alt="{{$user->image ? $user->name:'User profile picture'}}">
    </div>
    <h3 class="profile-username text-center">{{$user->name}}</h3>
    <p class="text-muted text-center">{{$user->roles->first()->display_name}}</p>
    <ul class="list-group list-group-unbordered mb-3">
      <li class="list-group-item">
        <i class="fas fa-envelope mr-1"></i><b>Email</b> <a class="float-right">{{$user->email}}</a>
      </li>
      <li class="list-group-item">
        <i class="fas fa-key mr-1"></i><b>Token</b> <a class="float-right">{{$user->api_token}}</a>
      </li>
      <li class="list-group-item">
        <b>Friends</b> <a class="float-right">13,287</a>
      </li>
    </ul>
    <button type="button" class="btn btn-primary btn-block" wire:click="$emit('editProfile')"><b>Edit my profile</b></button>
  </div>
  <!-- /.card-body -->
  <x-modal title="My Profile" id="modal-profile" type="">
    <livewire:user.profile-form :user="$user" />
  </x-modal>
</div>