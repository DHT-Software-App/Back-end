<?php

     

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Employee;
use App\Models\EmployeeContact;
use App\Http\Resources\EmployeeResource;
use App\Http\Controllers\MailerController;
use App\Http\Controllers\FunctionsController;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\API\RegisterController;


class EmployeeController extends BaseController
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $employees = \DB::select("SELECT e.id,e.first_name,e.last_name,e.street,
        e.email,e.id_city,ci.city,e.id_state,s.state,e.zip,e.employee_status,
        GROUP_CONCAT(ec.contact) contact
       FROM `dry_employee` e
       LEFT JOIN `dry_cities` ci ON ci.id = e.id_city
       LEFT JOIN `dry_states` s ON s.id = e.id_state
       LEFT JOIN `dry_employee_contact` ec ON ec.id_employee = e.id
        WHERE e.`user_deleted`=? GROUP BY e.id ", [0]);
        return $this->sendResponse(EmployeeResource::collection($employees), 'Employee retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        $validate = new FunctionsController();

        $camps = ['userid' => 'required', 'first_name' => 'required','last_name' => 'required','email' => 'required',
            'street' => 'required','id_city' => 'required','id_state' => 'required', 'zip' => 'required'
        ];

        $validator = $validate->validateCamps($request,$camps);
        $input = $request->all();

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $employees = new Employee();
        $employees->first_name = $request->first_name;
        $employees->last_name = $request->last_name;
        $employees->email = $request->email;
        $employees->street = $request->street;
        $employees->id_city = $request->id_city;
        $employees->id_state = $request->id_state;
        $employees->zip = $request->zip;
        $employees->employee_status = 1;
        $employees->user_deleted = 0;
        $employees->user_updated = 0;
        $employees->user_created = 0;

        $instance = [];
        
        try {
            if ($employees->save())

            $this->detailsContact($request->userid,$employees->id,$input['contact']);
            $message = 'Employee retrieved successfully';
            $instance = new EmployeeResource($employees);
         
            RegisterController::insertNewUser($employees->email,$employees->id,"dry_employees" );

            $sendmail = new MailerController();
            $sendmail->SendEmail($employees, "New User","templatesemail/newusers.html");
         
        } catch (\Throwable $th) {
           $message = $th;
        }
        return $this->sendResponse(  $instance, $message);

    }

    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $customers = Employee::find($id);

        if (is_null($customers)) {
            return $this->sendError('Customers not found.');
        }
        return $this->sendResponse(new EmployeeResource($customers), 'Costumers retrieved successfully.');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

        $employees = Employee::find($id);

        $input = $request->all();

        $validator = Validator::make($input, [
            'userid' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'street' => 'required',
            'id_city' => 'required',
            'id_state' => 'required',
            'zip' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $updated= $employees->fill($request->all())->save();

        try {
            if ($updated)
            $this->detailsContact($request->userid,$employees->id,$input['contact']);
           
            $message = 'Employee updated successfully';
           
        } catch (\Throwable $th) {
            $message = $th;
        }
        return $this->sendResponse(new EmployeeResource($employees), $message);    
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$idemployee)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'userid' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }else{
            \DB::update('update dry_employee_contact set contact_status = 0, user_deleted ='.$request->userid.' , deleted_at=CURRENT_TIMESTAMP where id = ' .$idemployee);
            return $this->sendResponse([], 'Employee deleted.');
        }
    }
   
    public function detailsContact($iduser,$idemployee,$contacts)
    {
        \DB::update('update dry_employee_contact set contact_status = 0, user_deleted ='.$iduser.' , deleted_at=CURRENT_TIMESTAMP where contact_status = 1 and id_employee = ' .$idemployee);
       
        foreach ($contacts as $contactskey => $contact) {
            $customercontact = new EmployeeContact();
            $customercontact->id_employee = $idemployee;
            $customercontact->contact=$contact;
            $customercontact->user_deleted=0;
            $customercontact->user_updated=0;
            $customercontact->user_created=0;
            $customercontact->contact_status =1;
            $customercontact->save();   
        }
    }

    public function detailsEmployeesContact($idemployee)
    {
        $employeeContact = \DB::table('dry_employee_contact')->where('id_employee', $idemployee)->get();
        return $employeeContact;
    }
}