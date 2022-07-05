<?php

     

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Role;
use App\Models\AssingRermission;
use Validator;
use App\Http\Resources\RolesResource;

class RolesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $roles = Role::all();
        return $this->sendResponse(RolesResource::collection($roles), 'Roles retrieved successfully.');
    }
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $user = \DB::select(
            "SELECT e.id,u.role,e.first_name,e.street,e.last_name,e.email,e.id_city,e.id_state,e.zip,'employee'
            FROM dryhitec.dry_employee e, dryhitec.dry_users u 
            where e.email = u.email and u.user_status=1 and u.user_deleted=0  and u.email='$id'
            and e.employee_status = 1 and e.user_deleted=0"
        );
        
        if (is_null($user)) {
            return $this->sendError('Customers not found.');
        }
        return $this->sendResponse(UserResource::collection($user), 'User retrieved successfully.');
    }
   
    public function store(Request $request){

        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required'
        ]);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $role = new Role();
        $role->name = $request->name;
        $role->guard_name = "web";
        $instance = [];

        try {
            if ($role->save())
            //Save details customers
            $message = 'Role retrieved successfully';
            $instance = new RolesResource($role);
        } catch (\Throwable $th) {
            $message = $th;
        }
        return $this->sendResponse($instance, $message);

    }

    public function assingRoles (Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'idRol' => 'required',
            'idPermission' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        if(count($input['idPermission'])>0)
        {
            foreach ($input['idPermission'] as $contactskey => $permission) {
               
                \DB::delete('delete from role_has_permissions where role_id = ? and permission_id = ?', [$input['idRol'], $permission]);
              
                \DB::insert('insert into role_has_permissions 
                (role_id,permission_id) values (?, ?)', [$input['idRol'], $permission]);
            }
        }
    }
}