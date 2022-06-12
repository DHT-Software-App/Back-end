<?php

     

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Clients;
use App\Models\ClientsContact;
use App\Models\ClientsEmail;
use Validator;
use App\Http\Resources\ClientsResource;

class ClientsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        //$clients = Clients::all();
        $clients = \DB::select("SELECT c.id,c.person_contact, c.company, c.email, c.street,c.id_city,c.id_state,c.zip,c.client_status,
        GROUP_CONCAT(cc.`contact`) contact, GROUP_CONCAT(ce.`email`) email
        FROM dry_clients c
        LEFT JOIN `dry_clients_contact` cc ON cc.`id_client`=c.`id`
        LEFT JOIN `dry_clients_email` ce ON ce.`id_client`=c.`id`
        WHERE c.`user_deleted`=?
        GROUP BY c.`id`",[0]);
        return $this->sendResponse(
            ClientsResource::collection($clients), 
            'clients retrieved successfully.'
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
            'person_contact' => 'required',
            'company' => 'required',
            'email' => 'required',
            'street' => 'required',
            'id_city' => 'required',
            'id_state' => 'required',
            'zip' => 'required'
        ]);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $clients = new Clients();
        $clients->person_contact = $request->person_contact;
        $clients->company = $request->company;
        $clients->email = $request->email;
        $clients->street = $request->street;
        $clients->id_city = $request->id_city;
        $clients->id_state = $request->id_state;
        $clients->zip = $request->zip;
        $clients->client_status = 1;
        $clients->user_deleted = 0;
        $clients->user_updated = 0;
        $clients->user_created = 0;

        try {
            if ($clients->save())
            //Save details customers
            $this->detailsContact($request->userid,$clients->id,$input['contact']);
            $this->detailsEmail($request->userid,$clients->id,$input['email']);
            $message = 'Client retrieved successfully';
            
        } catch (\Throwable $th) {
            $message = $th;
        }
        return $this->sendResponse(new ClientsResource($clients), $message);

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $clients = Clients::find($id);

        if (is_null($clients)) {
            return $this->sendError('Client not found.');
        }
        return $this->sendResponse(new ClientsResource($clients), 'Client retrieved successfully.');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

        $clients = Clients::find($id);

        $input = $request->all();

        $validator = Validator::make($input, [
            'person_contact' => 'required',
            'company' => 'required',
            'email' => 'required',
            'street' => 'required',
            'id_city' => 'required',
            'id_state' => 'required',
            'zip' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $updated= $clients->fill($request->all())->save();

        try {
            if ($updated)
             //Save details customers
            $this->detailsContact($request->userid,$clients->id,$input['contact']);
            $this->detailsEmail($request->userid,$clients->id,$input['email']);
            $message = 'Client updated successfully';
           
        } catch (\Throwable $th) {
            $message = $th;
        }
        return $this->sendResponse(new ClientsResource($clients), $message);    
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$idclient)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'userid' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }else{
        \DB::update('update dry_clients set client_status = 0, user_deleted ='.$request->userid.' , deleted_at=CURRENT_TIMESTAMP where client_status=1 and id = ' .$idclient);
       
        return $this->sendResponse([], 'Client deleted.');
        } 
    }

    public function detailsContact($iduser,$idclient,$contacts)
    {
        \DB::update('update dry_clients_contact set contact_status = 0, user_deleted ='.$iduser.' , deleted_at=CURRENT_TIMESTAMP where contact_status = 1 and id_client = ' .$idclient);
       
        foreach ($contacts as $contactskey => $contact) {
            $customercontact = new ClientsContact();
            $customercontact->id_client = $idclient;
            $customercontact->contact=$contact;
            $customercontact->user_deleted=0;
            $customercontact->user_updated=0;
            $customercontact->user_created=0;
            $customercontact->contact_status =1;
            $customercontact->save();

               // try {
        //     if ($customercontact->save())
           
        //     } catch (\Throwable $th) {
        //         $message = $th;
        //     }
        // 
        }
    }

    public function detailsEmail($iduser,$idclient,$emails)
    {
        \DB::update('update dry_clients_email set email_status = 0, user_deleted ='.$iduser.' , deleted_at=CURRENT_TIMESTAMP where email_status = 1 and id_client = ' .$idclient);
       
        foreach ($emails as $email) {
            $customerinsured = new ClientsEmail();
            $customerinsured->id_client = $idclient;
            $customerinsured->email=$email;
            $customerinsured->user_deleted=0;
            $customerinsured->user_updated=0;
            $customerinsured->user_created=0;
            $customerinsured->email_status =1;
            $customerinsured->save();
        // try {
        //     if ($customercontact->save())
           
        //     } catch (\Throwable $th) {
        //         $message = $th;
        //     }
        // 
        }
    }
   
}