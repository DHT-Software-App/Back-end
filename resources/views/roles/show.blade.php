

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $role->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Permissions:</strong>
                @if(!empty($rolePermissions))
                    @foreach($rolePermissions as $rolepermission)
                        @foreach($permissions as $permission)
                            @if ($rolepermission==$permission->id)
                             <label class="label label-success">{{ $permission->name }},</label>
                            @endif
                           
                        @endforeach
                    @endforeach
                @endif
            </div>
        </div>
    </div>
