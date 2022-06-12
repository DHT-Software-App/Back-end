<?php

     

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\City;
use Validator;
use App\Http\Resources\CityResource;

class CityController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $cities = City::all();
        return $this->sendResponse(CityResource::collection($cities), 'city retrieved successfully.');
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
            'id_state' => 'required',
            'city' => 'required'
        ]);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $city = new City();
        $city->id_state = $request->id_state;
        $city->city = $request->city;
        $city->city_status = 1;
        $city->user_deleted = 0;
        $city->user_updated = 0;
        $city->user_created = 0;

        $instance = [];

        try {
            if ($city->save())
            //Save details customers
            $message = 'City retrieved successfully';
            $instance = new CityResource($city);
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
        $customers = City::find($id);

        if (is_null($customers)) {
            return $this->sendError('Customers not found.');
        }
        return $this->sendResponse(new CityResource($customers), 'Costumers retrieved successfully.');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

        $customers = City::find($id);

        $input = $request->all();

        $validator = Validator::make($input, [
            'id_state' => 'required',
            'city' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $updated= $customers->fill($request->all())->save();

        try {
            if ($updated)
             //Save details customers
            $message = 'Costumers updated successfully';
           
        } catch (\Throwable $th) {
            $message = $th;
        }
        return $this->sendResponse(new CityResource($customers), $message);    
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
        \DB::update('update dry_cities set city_status = 0, user_deleted ='.$request->userid.' , deleted_at=CURRENT_TIMESTAMP where id = ' .$idcity);
       
            return $this->sendResponse([], 'City deleted.');
        }
    }
   
}