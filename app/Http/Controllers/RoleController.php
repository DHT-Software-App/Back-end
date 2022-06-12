<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\RoleHasPermission;
use DB;
use DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::orderBy('id','DESC');
        
        return view('roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permissions' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->permissions);

        $message = "Save successfully";
        
        echo $message;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();
        $rolePermissions = DB::table("role_has_permissions")
                            ->where("role_has_permissions.role_id",$id)
                            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                            ->all();

        return view('roles.show',compact('role', 'rolePermissions','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permissions' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permissions'));

        return redirect()->route('roles.index')
                        ->with('success','Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::find($id)->delete();

        $message = "Delete successfully";
        
        echo $message;
    }

    //Load datatable
    public function loadDatatable(Request $request)
    {
        $data = \DB::select("SELECT id,name FROM roles");
            return Datatables::of($data)
            ->addColumn('action', function($row){
                $btn = '
                
                <div class="dropdown">
                    <a href="javascript:void(0);" class="btn btn-sm btn-light btn-active-light-primary  dropdown-toggle lastend" data-bs-toggle="dropdown"><i class="las la-cog size-25"></i></a>
                    <div class="dropdown-menu">
                        <a href="javascript:void(0);" rol-id="'.$row->id.'" class="dropdown-item rol-modal">'.__('View').'</a>
                        <a href="javascript:void(0);" rol-id="'.$row->id.'" data-token="{{ csrf_token() }}" class="dropdown-item rol-delete">'.__('Delete').'</a>
                    </div>
                </div>
                ';
  
                        return $btn;
                })
           
                    ->rawColumns(['action'])
                    ->make(true);
        
    }
}
