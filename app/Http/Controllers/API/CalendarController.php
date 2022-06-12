<?php

     

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Calendar;
use Validator;
use App\Http\Resources\CalendarResource;

class CalendarController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $calendar = Calendar::all();
        return $this->sendResponse(CalendarResource::collection($calendar), 'Calendar retrieved successfully.');
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
            'userid' => 'required',
            'id_jobs' => 'required',
            'id_technician' => 'required',
            'date_start_job' => 'required',
            'date_finish_job' => 'required',
            'note' => 'required'
        ]);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
    
        $calendar = new Calendar();
        $calendar->id_jobs = $request->id_jobs;
        $calendar->id_technician = $request->id_technician;
        $calendar->date_start_job = $request->date_start_job;
        $calendar->date_finish_job = $request->date_finish_job;
        $calendar->note = $request->note;
        $calendar->calendar_status = 1;
        $calendar->user_deleted = 0;
        $calendar->user_updated = 0;
        $calendar->user_created = $request->userid;

        $instance = [];

        try {
            if ($calendar->save())
            $message = 'Calendar retrieved successfully';
            $instance = new CalendarResource($calendar);
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
        $calendars = Calendar::find($id);

        if (is_null($calendars)) {
            return $this->sendError('Calendar not found.');
        }
        return $this->sendResponse(new CalendarResource($calendars), 'Calendar retrieved successfully.');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

        $calendars = Calendar::find($id);

        $input = $request->all();

        $validator = Validator::make($input, [
            'userid' => 'required',
            'id_jobs' => 'required',
            'id_technician' => 'required',
            'date_start_job' => 'required',
            'date_finish_job' => 'required',
            'note' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $updated= $calendars->fill($request->all())->save();

        try {
            if ($updated)
             //Save details Calendar
            $message = 'Calendar updated successfully';
           
        } catch (\Throwable $th) {
            $message = $th;
        }
        return $this->sendResponse(new CalendarResource($calendars), $message);    
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$idcity)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'userid' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }else{
        \DB::update('update dry_caledar set calendar_status = 0, user_deleted ='.$request->userid.' , deleted_at=CURRENT_TIMESTAMP where id = ' .$idcity);
       
            return $this->sendResponse([], 'Calendar deleted.');
        }
    }
   
}