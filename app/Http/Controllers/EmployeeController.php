<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Symfony\Component\HttpFoundation\Response;
use Spatie\QueryBuilder\QueryBuilder;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->middleware('able:view:employees');
    }

    public function index()
    {
        // get user's employee
        $authenticated = auth()->user()->employee;
        $str_roles = [];

        foreach ($authenticated->getAbilities()->where('title', 'employees') as $ability) {
            if (str_contains($ability->name, 'create')) {
                array_push($str_roles, explode(':', $ability->name)[1]);
            }
        }


        $fields = \Schema::getColumnListing('employees');

        // whereIs: get all employees with specified roles.
        $employees = QueryBuilder::for(Employee::whereIs(...$str_roles))
            ->allowedFilters($fields)
            ->allowedSorts($fields)
            ->paginate(15)
            ->appends(request()->query());

        return new EmployeeCollection($employees);
    }

    public function show(Employee $employee)
    {
        $ownedRole = $employee->getRoles()->first();

        // calling policy
        $this->authorize('view', [Ability::class, $ownedRole]);

        return response()->json(new EmployeeResource($employee), Response::HTTP_OK);
    }

    public function store(EmployeeRequest $request)
    {
        $employee = Employee::create($request->validated());

        return response()->json(new EmployeeResource($employee), Response::HTTP_CREATED);
    }


    public function update(EmployeeRequest $request, Employee $employee)
    {
        // update employee after confirming action completed
        if ($employee->update($request->validated())) {
            return response()->json(new EmployeeResource($employee), Response::HTTP_OK);
        }
    }

    public function delete(Employee $employee)
    {
        $ownedRole = $employee->getRoles()->first();

        // calling policy
        $this->authorize('delete', [Ability::class, $ownedRole]);

        // // delete employee
        $employee->delete();

        return response()->json([
            'success' => true,
            'message' => 'Employee deleted successfully',
            'code' => 'DELETED'
        ], Response::HTTP_NO_CONTENT);
    }
}
