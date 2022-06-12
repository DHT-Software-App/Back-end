<?php

     

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Customers;
use App\Models\CustomersContact;
use App\Models\CustomersInsured;
use Validator;
use App\Http\Resources\CustomersResource;
use App\Http\Controllers\MailerController;
use App\Http\Controllers\API\RegisterController;

class CustomersController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $customers = \DB::select("SELECT c.id,c.first_name,c.last_name,c.street, '' contact,
       '' insured,
         c.email,c.id_city,c.id_state,c.zip,c.customer_status
        FROM `dry_customers` c
        WHERE c.`user_deleted`=?",[0]);
        return $this->sendResponse(
            CustomersResource::collection($customers), 
            'Customers retrieved successfully.'
        );
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        $input = $request->all();
        $validator = Validator::make($input, [
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

        $customers = new Customers();
        $customers->first_name = $request->first_name;
        $customers->last_name = $request->last_name;
        $customers->email = $request->email;
        $customers->street = $request->street;
        $customers->id_city = $request->id_city;
        $customers->id_state = $request->id_state;
        $customers->zip = $request->zip;
        $customers->customer_status = 1;
        $customers->user_deleted = 0;
        $customers->user_updated = 0;
        $customers->user_created = 0;

        $instance = [];
        
        try {
            if ($customers->save())
            
            $customers->contact =  $this->detailsContact($request->userid,$customers->id,$input['contact']);
            $customers->insured =  $this->detailsInsured($request->userid,$customers->id,$input['insured']);
            $instance = new CustomersResource($customers);
         
            RegisterController::insertNewUser($customers->email,$customers->id,"dry_customers" );
            MailerController::SendEmail($customers, "New User","templatesemail/newcustomers.html");
            $message = 'Costumers retrieved successfully';
            
        } catch (\Throwable $th) {
            $message = $th;
        }
        return $this->sendResponse($instance, $message);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $customers = \DB::select("SELECT c.id,c.first_name,c.last_name,c.street, '' contact,
       '' insured,
         c.email,c.id_city,c.id_state,c.zip,c.customer_status
        FROM `dry_customers` c
        WHERE c.`user_deleted`={$id}
        GROUP BY c.`id`");
        if (is_null($customers)) {
            return $this->sendError('Customers not found.');
        }
        return $this->sendResponse(new CustomersResource($customers), 'Costumers retrieved successfully.');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

        $customers = Customers::find($id);

        $input = $request->all();

        $validator = Validator::make($input, [
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
        $updated= $customers->fill($request->all())->save();

        try {
            if ($updated)
             //Save details customers
             $customers->contact =  $this->detailsContact($request->userid,$customers->id,$input['contact']);
            $customers->insured =  $this->detailsInsured($request->userid,$customers->id,$input['insured']);
            $message = 'Costumers updated successfully';
           
        } catch (\Throwable $th) {
            $message = $th;
        }
        return $this->sendResponse(new CustomersResource($customers), $message);    
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idcustomers,$idusers,$message = 0)
    {
        \DB::update('update dry_customers set customer_status = 0, user_deleted ='.$idusers.' , deleted_at=CURRENT_TIMESTAMP where id = ' .$idcustomers);
       
        if($message!=0)
        {
            return $this->sendResponse([], 'Costumers deleted.');
        }
    }

    public function detailsContact($iduser,$idcustomers,$contacts)
    {
        \DB::update('update dry_customer_contact set customer_status = 0, user_deleted ='.$iduser.' , deleted_at=CURRENT_TIMESTAMP where customer_status = 1 and id_customers = ' .$idcustomers);
       
        $arrayCustomercontact = [];
        foreach ($contacts as $contactskey => $contact) {
            $customercontact = new CustomersContact();
            $customercontact->id_customers = $idcustomers;
            $customercontact->telephone=$contact;
            $customercontact->user_deleted=0;
            $customercontact->user_updated=0;
            $customercontact->user_created=0;
            $customercontact->customer_status =1;
            $customercontact->save();
            $arrayCustomercontact[] = $customercontact;
         }
    return $arrayCustomercontact;
    }

    public function detailsInsured($iduser,$idcustomers,$insureds)
    {
        \DB::update('update dry_customer_insured set insured_status = 0, user_deleted ='.$iduser.' , deleted_at=CURRENT_TIMESTAMP where insured_status = 1 and id_customers = ' .$idcustomers);
       
        $arrayCustomerInsured = [];
        foreach ($insureds as $insured) {
            $customerinsured = new CustomersInsured();
            $customerinsured->id_customers = $idcustomers;
            $customerinsured->first_name=$insured['first_name'];
            $customerinsured->last_name=$insured['last_name'];
            $customerinsured->user_deleted=0;
            $customerinsured->user_updated=0;
            $customerinsured->user_created=0;
            $customerinsured->insured_status =1;
            $customerinsured->save();
        // try {
        //     if ($customercontact->save())
           
        //     } catch (\Throwable $th) {
        //         $message = $th;
        //     }
        // 
        $arrayCustomerInsured[] = $customerinsured;
        }
        return $arrayCustomerInsured;
    }
   
    public function detailsCustomerContact($id_customer)
    {
        $customerContact = \DB::table('dry_customer_contact')->where('id_customers', $id_customer)->get();
        return $customerContact;
    }

    public function detailsCustomerInsured($id_customer)
    {
        $customerInsured = \DB::table('dry_customer_insured')->where('id_customers', $id_customer)->get();
        return $customerInsured;
    }
}