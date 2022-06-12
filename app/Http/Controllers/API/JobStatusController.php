<?php

     

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\JobStatus;
use Validator;
use App\Http\Resources\JobStatusResource;

class JobStatusController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $typejobs = JobStatus::all();
        return $this->sendResponse(JobStatusResource::collection($typejobs), 'Type Job retrieved successfully.');
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
            'type_job' => 'required'
        ]);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $typejobs = new JobStatus();
        $typejobs->type_job = $request->type_job;
        $typejobs->job_status = 1;
        $typejobs->user_deleted = 0;
        $typejobs->user_updated = 0;
        $typejobs->user_created = 0;

        $instance = [];

        try {
            if ($typejobs->save())
            //Save details customers
            $message = 'Type Jobs retrieved successfully';
            $instance = new JobStatusResource($typejobs);
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
        $typejobs = JobStatus::find($id);

        if (is_null($typejobs)) {
            return $this->sendError('Type Jobs not found.');
        }
        return $this->sendResponse(new JobStatusResource($typejobs), 'Type Jobs retrieved successfully.');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

        $typejobs = JobStatus::find($id);

        $input = $request->all();

        $validator = Validator::make($input, [
            'type_job' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $updated= $typejobs->fill($request->all())->save();

        try {
            if ($updated)
            $message = 'State updated successfully';
           
        } catch (\Throwable $th) {
            $message = $th;
        }
        return $this->sendResponse(new JobStatusResource($typejobs), $message);    
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$idtypejob){
        $input = $request->all();

        $validator = Validator::make($input, [
            'userid' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }else{
            \DB::update('update dry_job_status set job_status = 0, user_deleted ='.$request->userid.' , deleted_at=CURRENT_TIMESTAMP where id = ' .$idtypejob);
            return $this->sendResponse([], 'Type Job deleted.');
        }
    }
   
}