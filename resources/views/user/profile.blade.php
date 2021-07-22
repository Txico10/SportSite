@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
      <h1 class="m-0 text-dark">My Profile</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@stop
@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">
        <livewire:user.profile :user="$user"/>
        @if (!empty($user->contact))
            <livewire:management.contact :contact="$user->contact" />
        @elseif($user->employees->count()>0)
          @foreach ($user->employees as $employee)
            <livewire:management.contact :contact="$employee->contact" />
          @endforeach
        @else
          <p>Not available</p>
        @endif
      </div>
      <div class="col-md-9">
        <div class="card card-primary card-outline">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#myprofile" data-toggle="tab">Profile</a></li>
              <li class="nav-item"><a class="nav-link" href="#contact" data-toggle="tab">Contact</a></li>
              <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
              <li class="nav-item px-1"><button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modal-resetPassword">Reset Password</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="myprofile">
                
              </div>
              <!-- /.tab-pane -->
              
              <div class="tab-pane" id="contact">
                @if(!empty($user->contact))
                  <livewire:management.contact-show :contacts="$user->contact"/>  
                @elseif($user->employees->count()>0)
                  <livewire:management.contact-show :contacts="$user->employees[0]->contact"/>  
                @else
                  <p>New Contact case</p>
                @endif
                
              </div>

              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                <!-- The timeline -->
                <div class="timeline timeline-inverse">
                  <!-- timeline time label -->
                  <div class="time-label">
                    <span class="bg-danger">
                      10 Feb. 2014
                    </span>
                  </div>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <div>
                    <i class="fas fa-envelope bg-primary"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="far fa-clock"></i> 12:05</span>

                      <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                      <div class="timeline-body">
                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                        weebly ning heekya handango imeem plugg dopplr jibjab, movity
                        jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                        quora plaxo ideeli hulu weebly balihoo...
                      </div>
                      <div class="timeline-footer">
                        <a href="#" class="btn btn-primary btn-sm">Read more</a>
                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                      </div>
                    </div>
                  </div>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <div>
                    <i class="fas fa-user bg-info"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                      <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                      </h3>
                    </div>
                  </div>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <div>
                    <i class="fas fa-comments bg-warning"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                      <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                      <div class="timeline-body">
                        Take me to your leader!
                        Switzerland is small and neutral!
                        We are more like Germany, ambitious and misunderstood!
                      </div>
                      <div class="timeline-footer">
                        <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                      </div>
                    </div>
                  </div>
                  <!-- END timeline item -->
                  <!-- timeline time label -->
                  <div class="time-label">
                    <span class="bg-success">
                      3 Jan. 2014
                    </span>
                  </div>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <div>
                    <i class="fas fa-camera bg-purple"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                      <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                      <div class="timeline-body">
                        <img src="http://placehold.it/150x100" alt="...">
                        <img src="http://placehold.it/150x100" alt="...">
                        <img src="http://placehold.it/150x100" alt="...">
                        <img src="http://placehold.it/150x100" alt="...">
                      </div>
                    </div>
                  </div>
                  <!-- END timeline item -->
                  <div>
                    <i class="far fa-clock bg-gray"></i>
                  </div>
                </div>
              </div>
              <!-- /.tab-pane -->
          </div><!-- /.card-body -->
        </div><!-- /.card -->
      </div>
    </div>
  </div>
  </div>
  <x-modal title="Reset Password" id="modal-resetPassword" type="" icon="fas fa-lock">
    <livewire:user.reset-password/>
  </x-modal>
@stop

@section('footer')
  <strong>Copyright &copy; 2016-2019 <a href="#">Torneio Bedjo</a>.</strong> All rights reserved.
@stop

@section('js')
  <script>
    $(document).ready(function() {
      $('#type').select2();
      $('#relationship').select2();

      $("#modal-contact").on('hidden.bs.modal', function(){
        Livewire.emit('resetContactInputFiels');
        $('#type').prop('disabled',false);
        $("#type").val('').trigger('change');
        $('#relationship').prop('disabled',false);
        $("#relationship").val('').trigger('change');
      });

      $("#modal-profile").on('hidden.bs.modal', function(){
        Livewire.emit('resetProfileInputFields');
        
      });

      $("#modal-resetPassword").on('hidden.bs.modal', function(){
        Livewire.emit('resetPasswordInputFields');
        
      });
      
      $("#type").on('select2:select', function(event){
          var data = $(this).select2("val");
          var formID = document.getElementById("contact-form");
          Livewire.find(formID.getAttribute('wire:id')).set('type', data);
          console.log(data);
      });

      $("#relationship").on('select2:select', function(event){
          var data = $(this).select2("val");
          var formID = document.getElementById("contact-form");
          Livewire.find(formID.getAttribute('wire:id')).set('relationship', data);
          console.log(data);
      });
    });

    window.addEventListener('openModalResetPassword', event => {
      $("#modal-resetPassword").modal('show');
    });

    window.addEventListener('closeModalResetPassword', event => {
      $("#modal-resetPassword").modal('hide');
    });

    window.addEventListener('closeContactModal', event => {
      $("#modal-contact").modal('hide');
    });

    window.addEventListener('openContactModal', event => {
        
      if(event.detail.type==="primary"){
        $("#type").prop('disabled', true);
        $('#relationship').prop('disabled',true);
        //$('#name').prop('disabled',true);
        //$('#email').val(event.detail.email).trigger('change');
        //$('#email').prop('disabled',true);
      }else {
        $('#type option[value='+event.detail.type+']').prop('selected',true);
        $('#type').trigger('change');
        $('#relationship option[value='+event.detail.relationship+']').prop('selected',true);
        $('#relationship').trigger('change');
      }
      
      $("#modal-contact").modal('show');
    });

    window.addEventListener('openModalProfile', event => {
      $("#modal-profile").modal('show');
    });
    window.addEventListener('closeModalProfile', event => {
      $("#modal-profile").modal('hide');
    });

    document.addEventListener("livewire:load", () => {
      Livewire.hook('message.processed', (message, component) => {
        $('#type').select2();
        $('#relationship').select2();
      }); 
    });

    Livewire.on('alert', param => {
        toastr[param['type']](param['message']);
    });

    Livewire.on('triggerDeleteContact', contactID => {
    Swal.fire({
      title: 'Are You Sure?',
      text: 'The contact will be deleted!',
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Delete!'
      }).then((result) => {
		//if user clicks on delete
        if (result.value) {
		    // calling destroy method to delete
        Livewire.emit('deleteContact', contactID);
        } 
      });
    });

  </script>
@stop