<?php

     

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\State;
use Validator;
use App\Http\Resources\StateResource;

class StateController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $states = State::all();
        return $this->sendResponse(StateResource::collection($states), 'state retrieved successfully.');
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
            'state' => 'required'
        ]);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $state = new State();
        $state->state = $request->state;
        $state->state_status = 1;
        $state->user_deleted = 0;
        $state->user_updated = 0;
        $state->user_created = 0;

        $instance = [];

        try {
            if ($state->save())
            //Save details customers
            $message = 'State retrieved successfully';
            $instance = new StateResource($state);
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
        $customers = State::find($id);

        if (is_null($customers)) {
            return $this->sendError('Customers not found.');
        }
        return $this->sendResponse(new StateResource($customers), 'Costumers retrieved successfully.');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

        $state = State::find($id);

        $input = $request->all();

        $validator = Validator::make($input, [
            'state' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $updated= $state->fill($request->all())->save();

        try {
            if ($updated)
            $message = 'State updated successfully';
           
        } catch (\Throwable $th) {
            $message = $th;
        }
        return $this->sendResponse(new StateResource($state), $message);    
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$idstate)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'userid' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }else{
            \DB::update('update dry_states set state_status = 0, user_deleted ='.$request->userid.' , deleted_at=CURRENT_TIMESTAMP where id = ' .$idstate);
            return $this->sendResponse([], 'State deleted.');
        }
    }
   
}