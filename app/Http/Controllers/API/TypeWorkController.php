<?php

     

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\TypeWork;
use Validator;
use App\Http\Resources\TypeWorkResource;

class TypeWorkController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $typeworks = TypeWork::all();
        return $this->sendResponse(TypeWorkResource::collection($typeworks), 'Type Work retrieved successfully.');
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
            'type_work' => 'required'
        ]);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $typework = new TypeWork();
        $typework->type_work = $request->type_work;
        $typework->job_status = 1;
        $typework->user_deleted = 0;
        $typework->user_updated = 0;
        $typework->user_created = 0;

        $instance = [];

        try {
            if ($typework->save())
            //Save details customers
            $message = 'Type Work retrieved successfully';
            $instance = new TypeWorkResource($typework);
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
        $typeworks = TypeWork::find($id);

        if (is_null($typeworks)) {
            return $this->sendError('Type Work not found.');
        }
        return $this->sendResponse(new TypeWorkResource($typeworks), 'Type Work retrieved successfully.');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

        $typeworks = TypeWork::find($id);

        $input = $request->all();

        $validator = Validator::make($input, [
            'type_work' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $updated= $typeworks->fill($request->all())->save();

        try {
            if ($updated)
            $message = 'Type Work updated successfully';
           
        } catch (\Throwable $th) {
            $message = $th;
        }
        return $this->sendResponse(new TypeWorkResource($typeworks), $message);    
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$idtypejob)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'userid' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }else{
            \DB::update('update dry_type_work set job_status = 0, user_deleted ='.$request->userid.' , deleted_at=CURRENT_TIMESTAMP where id = ' .$idtypejob);
            return $this->sendResponse([], 'Type Work deleted.');
        }
    }
   
}