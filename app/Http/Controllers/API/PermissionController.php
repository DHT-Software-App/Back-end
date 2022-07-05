<?php

     

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Permission;
use Validator;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\PermissionDetailsResource;
use stdClass;

class PermissionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $permission = Permission::all();
        return $this->sendResponse(PermissionResource::collection($permission), 'Permission retrieved successfully.');
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
            return $this->sendError('Role not found.');
        }
        return $this->sendResponse(PermissionResource::collection($user), 'Permission retrieved successfully.');
    }
   
    public function store(Request $request){

        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required'
        ]);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $permission = new Permission();
        $permission->name = $request->name;
        $permission->guard_name = "web";
        $instance = [];

        try {
            if ($permission->save())
            $message = 'Permission retrieved successfully';
            $instance = new PermissionResource($permission);
        } catch (\Throwable $th) {
            $message = $th;
        }
        return $this->sendResponse($instance, $message);

    }

    public function showDetailsPermission($idRol)
    {
        $permissionDetails = \DB::select("use dryhitec;
        select p.id, p.name from role_has_permissions hp
        inner join permissions p on p.id = hp.permission_id
        inner join roles r on r.id = hp.role_id
        where r.id = '{$idRol}");

        $data  = new stdClass();

        foreach ($permissionDetails as $key => $permissionDetail) {
           $data->name[]=$permissionDetail->name;
        }
        return $this->sendResponse(PermissionResource::collection($user), 'User retrieved successfully.');

    }

    public function rolesPermission($idRol)
    {
        $rolePermission = \DB::select("select r.id idrol,r.name namerol,p.id, p.name from role_has_permissions hp
        inner join permissions p on p.id = hp.permission_id
        inner join roles r on r.id = hp.role_id
        where r.id = ?
        ",[$idRol]);

        $data = new stdClass();
        $data->success = false;
        $data->message="Roles with permission no found.";
        if(count($rolePermission)>0) {
            $data->success =true;
            $data->nameRol = $rolePermission[0]->namerol;
            $data->idRol = $rolePermission[0]->idrol;

            foreach ($rolePermission  as $key => $value) {
            
                $data->idPermission[] = $value->id;
                $data->namePermission[] = $value->name;
            }
            $data->message="Roles with permission retrieved successfully.";
        }
        
       
        
       return $data ;

    }
}