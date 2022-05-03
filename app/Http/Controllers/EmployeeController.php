<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Http\Resources\InvalidAttributeCollection;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    public function __contruct() {
        $this->middleware('auth:api');
    }

    public function index () {
        return 'all';
    }
    
    public function show(Employee $employee) {
        return $employee;
    }

    public function create(Request $request) {
   
        $validator = Validator::make($request->all(),[
            'firstname' => 'required|max:50|alpha',
            'lastname' => 'required|max:50|alpha',
            'email_address' => 'required|max:100|email|unique:employees',
            'contact_1' => 'required|max:50',
            'contact_2' => 'required|max:50',
            'state' => 'required|max:45',
            'street' => 'required|max:45',
            'city' => 'required|max:45',
            'zip' => 'required|numeric',
        ]);

        if ($validator->fails()) {
           $formatError = invalid_attribute_format($validator->errors());
           
            return response()->json(new InvalidAttributeCollection($formatError), Response::HTTP_BAD_REQUEST);
        }

        $employee = Employee::create($validator->validate());
        
        return response()->json(new EmployeeResource($employee), Response::HTTP_CREATED);
    }
}
