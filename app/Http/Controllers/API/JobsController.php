<?php

     

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Jobs;
use Validator;
use App\Http\Resources\JobsResource;

class JobsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $jobs = Jobs::all();
        return $this->sendResponse(JobsResource::collection($jobs), 'Job retrieved successfully.');
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
            'id_customers' => 'required',
            'id_insurance_company' => 'required',
            'policy_number' => 'required',
            'claim_number' => 'required',
            'date_loss' => 'required',
            'id_type_loss' => 'required',
            'text' => 'required',
            'referred_by' => 'required',
            'id_job_status' => 'required',
            'id_type_work' => 'required',
        ]);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $jobs = new Jobs();
        $jobs->id_customers = $request->id_customers;
        $jobs->id_insurance_company = $request->id_insurance_company;
        $jobs->policy_number = $request->policy_number;
        $jobs->claim_number = $request->claim_number;
        $jobs->date_loss = $request->date_loss;
        $jobs->id_type_loss = $request->id_type_loss;
        $jobs->text = $request->text;
        $jobs->referred_by = $request->referred_by;
        $jobs->id_job_status = $request->id_job_status;
        $jobs->id_type_work = $request->id_type_work;
        $jobs->job_status = 1;
        $jobs->user_deleted = 0;
        $jobs->user_updated = 0;
        $jobs->user_created = 0;

        $instance = [];

        try {
            if ($jobs->save())
            //Save details customers
            $message = 'Job retrieved successfully';
            $instance = new JobsResource($jobs);
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
        $jobs = Jobs::find($id);

        if (is_null($jobs)) {
            return $this->sendError('Jobs not found.');
        }
        return $this->sendResponse(new JobsResource($jobs), 'Jobs retrieved successfully.');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

        $jobs = Jobs::find($id);

        $input = $request->all();

        $validator = Validator::make($input, [
            'id_customers' => 'required',
            'policy_number' => 'required',
            'id_insurance_company' => 'required',
            'claim_number' => 'required',
            'date_loss' => 'required',
            'id_type_loss' => 'required',
            'text' => 'required',
            'referred_by' => 'required',
            'id_job_status' => 'required',
            'id_type_work' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $updated= $jobs->fill($request->all())->save();

        try {
            if ($updated)
            $message = 'Jobs updated successfully';
           
        } catch (\Throwable $th) {
            $message = $th;
        }
        return $this->sendResponse(new JobsResource($jobs), $message);    
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$idjob)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'id_customers' => 'required',
            'policy_number' => 'required',
            'id_insurance_company' => 'required',
            'claim_number' => 'required',
            'date_loss' => 'required',
            'id_type_loss' => 'required',
            'text' => 'required',
            'referred_by' => 'required',
            'id_job_status' => 'required',
            'id_type_work' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }else{
            \DB::update('update dry_jobs set job_status = 0, user_deleted ='.$request->userid.' , deleted_at=CURRENT_TIMESTAMP where id = ' .$idjob);
            return $this->sendResponse([], 'Job deleted.');
        }
    }
   
}