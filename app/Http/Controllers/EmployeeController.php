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
        $this->middleware('can:view employees', ['except' => []]); 
    }
    
    public function index () {
        $employees = Employee::all();

        return response()->json(new EmployeeCollection($employees), Response::HTTP_OK);
    }
    
    public function show($id) {
        $employee = Employee::find($id);

        if($employee == null) {
            return response()->json([
                'message' => 'Resource Not Found'
            ] , Response::HTTP_NOT_FOUND);
        }

        return response()->json(new EmployeeResource($employee), Response::HTTP_OK);
    }

    public function store(EmployeeRequest $request) {
        $employee = Employee::create($request->all());
        
        return response()->json(new EmployeeResource($employee), Response::HTTP_CREATED);
    }

    public function update(EmployeeRequest $request, $id) {
     
        $employee = Employee::updateOrCreate(["id" => $id], $request->all());
        
        return response()->json(new EmployeeResource($employee), Response::HTTP_OK);
    }

    public function delete($id) {
        $employee = Employee::find($id);

        if($employee) {
            $employee->delete();

            return response()->json([
                'messages' => 'Employee deleted successfully',
            ], Response::HTTP_NO_CONTENT);
        }

        return response()->json([
            'messages' => 'Resource Not Found',
        ], Response::HTTP_BAD_REQUEST);
       
    }
}
