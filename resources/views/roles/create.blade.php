<div id="form-errors"></div>

    <form method="post" id="formrols" action="{{ route('roles.store') }}" >
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" id="name" placeholder="Name" class="form-control">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Permission:</strong>
                    <select class="custom-select custom-select-lg mb-3" name="permissions[]" multiple>
                      <option selected>Select Permission</option>
                      @foreach($permissions as $permission)
                        <option value="{{ $permission->id }}"> {{ $permission->name }} </option>
                      @endforeach
                    </select>
                </div>
            </div>
            <div id="divresultRols"></div>
            <center>  
                <button type="submit"   class="btn btn-success">{{ __("Create")}}</button>
                <a href='javascript:void(0)' data-bs-dismiss="modal" class="btn btn-danger">{{ __("Close")}}</a>
            </center>
        </div>
    </form>