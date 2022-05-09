<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    public function index () {
        // obtiene empleados creados por el usuario autenticado.
        $employees = auth()->user()->creatorEmployees;

        return response()->json(new EmployeeCollection($employees), Response::HTTP_OK);
    }
    
    public function show($id) {
        $employee = auth()->user()->creatorEmployees->find($id);

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
        return auth()->user()->creatorEmployees->delete($id);
       
    }
}
