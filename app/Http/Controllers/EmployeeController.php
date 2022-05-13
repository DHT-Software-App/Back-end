<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => []]);
        $this->middleware('able:view:employees');
    }
    
    public function index () {
        // get user's employee
        $authenticated = auth()->user()->employee;
        $str_roles = [];

        foreach ($authenticated->getAbilities()->where('title','employees') as $ability) {
            if(str_contains($ability->name, 'create')) {
                array_push($str_roles,explode(':',$ability->name)[1]);
            }
        }

        // get all employees with specified roles.
        $employees = Employee::whereIs(...$str_roles)->get();
 
        return response()->json(new EmployeeCollection($employees), Response::HTTP_OK);
    }
    
    public function show(Employee $employee) {
        $ownedRole = $employee->getRoles()->first();

        // calling policy
        $this->authorize('view',[Ability::class, $ownedRole]);

        return response()->json(new EmployeeResource($employee), Response::HTTP_OK);
    }

    public function store(EmployeeRequest $request) {
        $employee = Employee::create($request->all());
        
        return response()->json(new EmployeeResource($employee), Response::HTTP_CREATED);
    }

    public function update(EmployeeRequest $request, Employee $employee) {
        // update employee after confirming action completed
        if($employee->update($request->all())) {
            return response()->json(new EmployeeResource($employee), Response::HTTP_OK);
        }   
    }

    public function delete(Employee $employee) {
        $ownedRole = $employee->getRoles()->first();

        // calling policy
        $this->authorize('delete',[Ability::class, $ownedRole]);

        // // delete employee
        $employee->delete();

        return response()->json([
            'messages' => 'Employee deleted successfully',
        ], Response::HTTP_NO_CONTENT);
   
    }
}
