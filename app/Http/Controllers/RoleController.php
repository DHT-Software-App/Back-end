<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Employee;
use Silber\Bouncer\Database\Ability;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => []]);
        $this->middleware('able:view:employees');
    }

    // route: /api/v1/employees/{employee}/role
    public function show(Employee $employee, $role) {
        // find assigned role by role id
        $role = $employee->roles->find($role);

        // verify that role exists
        if($role) {
            return response()->json(new RoleResource($role), Response::HTTP_OK);
        }

        $not_found_entity = 'Role';
  

        return response()->json([
            'success' => false,
            'message' => "{$not_found_entity} Not Found"
        ], Response::HTTP_NOT_FOUND);
       
    }

    // route: /api/v1/employees/{employee}/relationships/role
    // attach role to employee
    public function store(RoleRequest $request, Employee $employee) {

        // calling policy
        $this->authorize('create',[Ability::class, $request->name]);

        // removing existing role
        $employee->retract($employee->getRoles()->first());

        // attach new role
        $employee->assign($request->name);

        return response()->json(new RoleResource($employee->roles->first()));
    }

}
