<form id="user-role-permissions-form">
    <div class="row">
        <div class="col-md-12">                
            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-fw fa-user-tag"></i></span>
                    </div>
                    <input type="text" id="myteam" class="form-control" value="" disabled>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-fw fa-user-tag"></i></span>
                    </div>
                    <select class="form-control" id="user-role-form" data-ajax--url="/admin/users/{{$user->id}}/roles" data-placeholder = "Select permissions" style="width: 90%" data-allow-clear="true">
                        <option value=""></option>
                        @foreach($user->roles as $role)
                            @if($role->pivot->team_id==$team->id)
                                <option value="{{$role->id}}" selected="selected">{{$role->display_name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-fw fa-envelope"></i></span>
                    </div>
                    <select class="form-control" id="user-permissions-form"  multiple="multiple" data-ajax--url="/admin/users/{{$user->id}}/permissions" data-placeholder = "Select permissions" style="width: 90%">
                        <option value="0"></option>
                        @foreach($user->permissions as $permission)
                            @if($permission->pivot->team_id==$team->id)
                                <option value="{{$permission->id}}" selected="selected">{{$permission->display_name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary float-right">Update</button>
            </div>
        </div>
    </div>
</form>