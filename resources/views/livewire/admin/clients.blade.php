<div class="card">
  <div class="card-header border-0">
    @permission('company-create')
        <button class="btn btn-outline-primary" data-toggle="modal" data-target="#modal-createcompany"><i class="fas fa-plus"></i> New Company</button>
        @endpermission
    <div class="card-tools">
      <div class="input-group input-group-sm" style="width: 150px;">
        <input type="text" wire:model="search" name="search" class="form-control float-right" placeholder="Search">
        <div class="input-group-append">
          <button class="btn btn-default"><i class="fas fa-search"></i></button>
        </div>
      </div>
    </div>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-striped table-valign-middle">
      <thead>
      <tr>
        <th>
          <a wire:click.prevent="sortBy('name')" role="button" href="#">Clients
            @include('includes._sort-icon', ['field' => 'name'])
          </a>
        </th>
        <th>Price</th>
        <th>Sales</th>
        <th>More</th>
      </tr>
      </thead>
      <tbody>
        @foreach($clients as $key => $client)
        <tr>
          <td>
          <img src={{asset('storage/profile_images/companies/'.$client->logo)}} alt="{{$client->name}}" class="img-circle img-size-32 mr-2">
            {{$client->name}}
          </td>
          <td>$13 USD</td>
          <td>
            <small class="text-success mr-1">
              <i class="fas fa-arrow-up"></i>
              12%
            </small>
            12,000 Sold
          </td>
          <td>
            <a href="{{route('company.profile', $client)}}" class="text-muted">
              <i class="fas fa-search"></i>
            </a>
          </td>
        </tr>    
        @endforeach
      </tbody>
    </table>
  </div>
  {{$clients->links()}}
</div>
<x-modal title="Register Company" id="modal-createcompany" type="modal-lg" icon="fas fa-building">
  <livewire:admin.clients-form/>
</x-modal>