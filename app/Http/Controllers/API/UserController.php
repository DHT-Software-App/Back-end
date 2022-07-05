<?php

     

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Validator;
use App\Http\Resources\UserResource;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $user = \DB::select(
            "SELECT e.id,u.role,e.first_name,e.street,e.last_name,e.email,e.id_city,e.id_state,e.zip,'employee'
            FROM dryhitec.dry_employee e, dryhitec.dry_users u 
            where e.email = u.email and u.user_status=1 and u.user_deleted=0 
            and e.employee_status = 1 and e.user_deleted=0
            union
            SELECT id,role,'','','',email,'','','','UsersMaster'
            from dryhitec.dry_users where role = 1
            order by role"
        );
        return $this->sendResponse(UserResource::collection($user), 'User retrieved successfully.');
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
            return $this->sendError('Rol no found not found.');
        }
        return $this->sendResponse(UserResource::collection($user), 'User retrieved successfully.');
    }

    public function userRolesPermissions($idUser)
    {
        $user = \DB::select(
            "SELECT e.id,u.role,e.first_name,e.street,e.last_name,e.email,e.id_city,e.id_state,e.zip,'employee'
            FROM dryhitec.dry_employee e, dryhitec.dry_users u 
            where e.email = u.email and u.user_status=1 and u.user_deleted=0 
            and e.employee_status = 1 and e.user_deleted=0
            union
            SELECT id,role,'','','',email,'','','','UsersMaster'
            from dryhitec.dry_users where role = 1
            order by role"
        );
        return $this->sendResponse(UserResource::collection($user), 'User retrieved successfully.');
    }
   
}