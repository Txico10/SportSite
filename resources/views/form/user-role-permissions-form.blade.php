<form id="user-role-permissions-form">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-fw fa-building"></i></span>
                    </div>
                    <input type="text" id="myteam" class="form-control" value="" disabled>
                    <input type="hidden" data-user="" id="myteamID" value="">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-fw fa-user-tag"></i></span>
                    </div>
                    <select class="form-control" id="user-role-form" multiple="multiple" data-ajax--url="/admin/users/{{$user->id}}/roles" data-placeholder = "Select permissions" style="width: 90%">

                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-fw fa-user-cog"></i></span>
                    </div>
                    <select class="form-control" id="user-permissions-form"  multiple="multiple" data-ajax--url="/admin/users/{{$user->id}}/permissions" style="width: 90%">

                    </select>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary float-right">Update</button>
            </div>
        </div>
    </div>
</form>
