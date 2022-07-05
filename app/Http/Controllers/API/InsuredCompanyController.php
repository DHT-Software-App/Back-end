<?php

     

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\InsuredCompany;
use App\Models\InsuredEmail;
use App\Models\InsuredContact;
use Validator;
use App\Http\Resources\InsuredCompanyResource;

class InsuredCompanyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $insuredcompany = \DB::select("
        SELECT ic.id,ic.company,ic.id_city,ci.city,ic.id_state,s.state,ic.zip,ic.street,
        GROUP_CONCAT(icc.`contact`) contact, GROUP_CONCAT(ice.`email`) email
        FROM `dry_insurance_company` ic
        LEFT JOIN `dry_cities` ci ON ci.id = ic.id_city
        LEFT JOIN `dry_states` s ON s.id = ic.id_state
        LEFT JOIN `dry_insurance_company_contact` icc ON icc.id_insurance_company = ic.id
        LEFT JOIN `dry_insurance_company_email` ice  ON ice.id_insurance_company = ic.id
        WHERE ic.`user_deleted`=?
        GROUP BY ic.`id`
        ", [0]);
        return $this->sendResponse(InsuredCompanyResource::collection($insuredcompany), 'Insured Company retrieved successfully.');
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
            'company' => 'required',
            'userid' => 'required',
            'street' => 'required',
            'id_city' => 'required',
            'id_state' => 'required',
            'zip' => 'required'
        ]);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $insuredcompany = new InsuredCompany();
        $insuredcompany->company = $request->company;
        $insuredcompany->street = $request->street;
        $insuredcompany->id_city = $request->id_city;
        $insuredcompany->id_state = $request->id_state;
        $insuredcompany->zip = $request->zip;
        $insuredcompany->insuredcompany_status = 1;
        $insuredcompany->user_deleted = 0;
        $insuredcompany->user_updated = 0;
        $insuredcompany->user_created = 0;

        try {
            if ($insuredcompany->save())
            //Save details customers
            $this->detailsContact($request->userid,$insuredcompany->id,$input['contact']);
            $this->detailsEmail($request->userid,$insuredcompany->id,$input['email']);
            $message = 'Insured Company retrieved successfully';
            
        } catch (\Throwable $th) {
            $message = $th;
        }
        return $this->sendResponse(new InsuredCompanyResource($insuredcompany), $message);

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $insuredcompany = InsuredCompany::find($id);

        if (is_null($insuredcompany)) {
            return $this->sendError('Insured Company not found.');
        }
        return $this->sendResponse(new InsuredCompanyResource($insuredcompany), 'Insured Company retrieved successfully.');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

        $insuredcompany = InsuredCompany::find($id);

        $input = $request->all();

        $validator = Validator::make($input, [
            'userid' => 'required',
            'company' => 'required',
            'street' => 'required',
            'id_city' => 'required',
            'id_state' => 'required',
            'zip' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $updated= $insuredcompany->fill($request->all())->save();

        try {
            if ($updated)
             //Save details customers
             $this->detailsContact($request->userid,$insuredcompany->id,$input['contact']);
             $this->detailsEmail($request->userid,$insuredcompany->id,$input['email']);
            $message = 'Insured Company updated successfully';
           
        } catch (\Throwable $th) {
            $message = $th;
        }
        return $this->sendResponse(new InsuredCompanyResource($insuredcompany), $message);    
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'userid' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        \DB::update('update dry_insurance_company set insuredcompany_status = 0, user_deleted ='.$request->userid.' , deleted_at=CURRENT_TIMESTAMP where id = ' .$id);
       
        
            return $this->sendResponse([], 'Insured Company deleted.');
        
    }

    public function detailsContact($iduser,$insuredcompany,$contacts)
    {
        \DB::update('update dry_insurance_company_contact set contact_status = 0, user_deleted ='.$iduser.' , deleted_at=CURRENT_TIMESTAMP where contact_status = 1 and id_insurance_company = ' .$insuredcompany);
       
        foreach ($contacts as $contactskey => $contact) {
            $customercontact = new InsuredContact();
            $customercontact->id_insurance_company = $insuredcompany;
            $customercontact->contact=$contact;
            $customercontact->user_deleted=0;
            $customercontact->user_updated=0;
            $customercontact->user_created=0;
            $customercontact->contact_status =1;
            $customercontact->save();   
        }
    }

    public function detailsEmail($iduser,$insuredcompany,$emails)
    {
        \DB::update('update dry_insurance_company_email set email_status = 0, user_deleted ='.$iduser.' , deleted_at=CURRENT_TIMESTAMP where email_status = 1 and id_insurance_company = ' .$insuredcompany);
      
        foreach ($emails as $emailskey => $email) {
            $customeremail = new InsuredEmail();
            $customeremail->id_insurance_company = $insuredcompany;
            $customeremail->email=$email;
            $customeremail->user_deleted=0;
            $customeremail->user_updated=0;
            $customeremail->user_created=0;
            $customeremail->email_status =1;
            $customeremail->save();   

            try {
                $customeremail->save();  
            } catch (\Throwable $th) {
              
            }
        }
    }
}