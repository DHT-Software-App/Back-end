
    <form method="post" action="{{ route('users.update', $user->id) }}" >
        @method('put')
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Email:</strong>
                    <input type="email" name="email" placeholder="Email" class="form-control" readonly value="{{ $user->email }}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Role:</strong>
                    <select class="custom-select custom-select-lg mb-3" name="roles[]" multiple>
                      <option selected>Select Role</option>
                      @foreach($roles as $role)
                        <option value="{{ $role->id }}" @if(in_array($role->id, $userRoles) ) selected @endif> {{ $role->name }} </option>
                      @endforeach
                    </select>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </form>
