$(function(){
    $('#legalform').select2({
      theme: 'bootstrap4',
      width: 'resolve'
    });
    $('#myBuildings').select2({
      theme: 'bootstrap4',
      width: 'resolve'
    });

    $('#apart_building').select2({
      width: 'resolve',
    });

    $('#apart_type').select2({
      width: 'resolve',
    });
    
    $("#lot").inputmask({
      mask: "9 999 999",
      //placeholder: "*",
      showMaskOnHover: true,
      showMaskOnFocus: false,
      oncomplete: function(){
        var formID = document.getElementById("buildingform");
        //console.log($(this).val());
        Livewire.find(formID.getAttribute('wire:id')).set('lot', $(this).val());
        $(this).addClass('is-valid').removeClass('is-invalid');
      },
      onincomplete: function(){
        if($(this).val()===""){
          $(this).removeClass('is-invalid');
          $(this).removeClass('is-valid');
          //console.log("incomplete vide")
        } else {
          var formID = document.getElementById("buildingform");
          Livewire.find(formID.getAttribute('wire:id')).set('lot', null);
          $(this).addClass('is-invalid').removeClass('is-valid');
        }
      },
    });

    $("#modal-company").on('hidden.bs.modal', function(){
        Livewire.emit('resetCompanyInputFields');      
      }
    );

    $("#modal-contact").on('hidden.bs.modal', function(){
        Livewire.emit('resetContactInputFiels');      
      }
    );

    $("#modal-building").on('hidden.bs.modal', function(){
        $('#lot').val('');
        $('#lot').removeClass('is-valid');
        $('#lot').removeClass('is-invalid');
        //$('#lot').removeAttr("disabled");
        Livewire.emit('resetBuildingInputFields');      
      }
    );

    $("#modal-apartment").on('hidden.bs.modal', function(){
        Livewire.emit('resetApartmentInputFiels');      
      }
    );
    

    $("#myBuildings").on('select2:select', function(event){
          var data = $(this).select2("val");
          var formID = document.getElementById("apartmentsList");
          Livewire.find(formID.getAttribute('wire:id')).set('buildingId', data);
          //console.log(data);
    });

    $("#apart_building").on('select2:select', function(event){
          var data = $(this).select2("val");
          var formID = document.getElementById("apartmentform");
          Livewire.find(formID.getAttribute('wire:id')).set('apart_building', data);
          //console.log(data);
    });

    $("#apart_type").on('select2:select', function(event){
          var data = $(this).select2("val");
          var formID = document.getElementById("apartmentform");
          Livewire.find(formID.getAttribute('wire:id')).set('apart_type', data);
          //console.log(data);
    });

});

document.addEventListener("livewire:load", () => {
    Livewire.hook('message.processed', (message, component) => {
        $('#myBuildings').select2({
          theme: 'bootstrap4',
          width: 'resolve'
        });
        
        $('#apart_building').select2({
          width: 'resolve',
        });

        $('#apart_type').select2({
          width: 'resolve',
        });
      }); 
    }
);

window.addEventListener('openContactModal', event => {
      $("#modal-contact").modal('show');
    }
);
  
  window.addEventListener('closeContactModal', event => {
      $("#modal-contact").modal('hide');
    }
  );

  window.addEventListener('closeCompanyModal', event => {
      $("#modal-company").modal('hide');
    }
  );

  window.addEventListener('openCompanyModal', event => {
      $("#modal-company").modal('show');
    }
  );

  window.addEventListener('openBuildingModal', event => {
      $('#lot').val(event.detail.lot);
      $('#lot').addClass('is-valid');
      //$('#lot').attr('disabled', 'disabled');
      $("#modal-building").modal('show');
    }
  );
  
  window.addEventListener('closeBuildingModal', event => {
      $("#modal-building").modal('hide');
    }
  );

  Livewire.on('alert', param => {
        toastr[param['type']](param['message']);
    }
  );

  window.addEventListener('openApartmentModal', event => {
      $("#modal-apartment").modal('show');
    }
  );

  window.addEventListener('closeApartmentModal', event => {
      $("#modal-apartment").modal('hide');
    }
  );