<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Employee;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => []]);
        $this->middleware('ability:view:employees');
    }

    // route: /api/v1/employees/{employee}/role
    public function show($employee, $role) {
        $employee = Employee::find($employee);
        $not_found_entity = 'Employee';

        if($employee) {
            $role = $employee->roles->find($role);

            if($role) {
                return response()->json(new RoleResource($role), Response::HTTP_OK);
            }

            $not_found_entity = 'Role';
        }

        return response()->json([
            'success' => false,
            'message' => "{$not_found_entity} Not Found"
        ], Response::HTTP_NOT_FOUND);
       
    }

    // route: /api/v1/employees/{employee}/relationships/role
    // attach role to employee
    public function store(RoleRequest $request, $employee) {
        $employee = Employee::find($employee);
        
        if($employee) {
            
            $employee->getRoles()->first();

            $employee->assign($request->role);

            return response()->json(new RoleResource($employee->roles->first()));
        }

        return response()->json([
            'success' => false,
            'message' => "Employee Not Found"
        ], Response::HTTP_NOT_FOUND);
       

    }

    // route: /api/v1/employees/{employee}/relationships/role
    // dettach role from employee
    public function delete(Request $request, $employee) {
        $employee = Employee::find($employee);
        $employee->retract($request->role);
    }

}
