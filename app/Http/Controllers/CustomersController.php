<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customers;
use DataTables;

class CustomersController extends Controller
{
    public function loadDatatable(Request $request)
    {
        $data = \DB::select("SELECT concat(first_name,' ',last_name) name,'' contact, email FROM dry_customers  where customer_status=0");
            return Datatables::of($data)
            ->addColumn('action', function($row){
                $btn = '
                <div class="dropdown">
                    <a href="#" class="btn btn-secondary  dropdown-toggle" data-bs-toggle="dropdown"><i class="ti-settings"></i></a>
                    <div class="dropdown-menu">
                        <a href="javascript:void(0);" client-id="'.$row->id.'" class="dropdown-item client-open-edit">'.__('Edit').'</a>
                        <a href="javascript:void(0);" onclick="deleteClient('.$row->id.')" class="dropdown-item">'.__('Delete').'</a>
                    </div>
                </div>
            
                <form  id="formdeleteclient" action="'.route('clients.destroy',$row->id).'" method="POST">
                '.csrf_field().'
                '.method_field("DELETE").'
                </form>';
  
                        return $btn;
                })
           
                    ->rawColumns(['action'])
                    ->make(true);
        
       // var_dump( );  
        return view('clients.index');
    }

    
    public function index(){
        $customers = Customers::orderBy('id', 'DESC')->get();

       return view('customers.index', compact('customers'));
    }

    public function show($id){
        $client = Customers::find($id);
        return view('customers.show', compact('client'));
    }
    public function create() {
        return view('customers.create');
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'carnet_id' => 'required',
            'address' => 'required',
            'telephone' => 'required',
            'email' => 'required',
            'cell_phone' => 'required',
        ]);

        
        $client = new Client();
        $client->name = $request->name;
        $client->contactname = $request->contactname;
        $client->carnet_id = $request->carnet_id;
        $client->address = $request->address;
        $client->telephone = $request->telephone;
        $client->email = $request->email;
        $client->month_birth = 0;
        $client->day_birth = 0;
        $client->cell_phone = $request->cell_phone;
        $client->client_status = 1;
        $client->client_deleted = 0;
        $client->user_updated = 0;
        $client->user_created = auth()->user()->id;
        $client->save();


        //return view('clients.show', compact('client', 'id'));
        switch(app()->getLocale())
		{
            case("es"):
                $message = "Registro guardado";
            break;
            case("en"):
                $message = "Save successfully";
            break;
        }
        echo $message;
      //  return redirect('/clients')->with('mensaje', $mensaje);
    }

    public function update(Request $request, $id) {
        $client = Client::find($id);

        $updated = $client->fill($request->all())->save();
        switch(app()->getLocale())
		{
            case("es"):
                $message = "Registro actualizado";
            break;
            case("en"):
                $message = "Save successfully";
            break;
        }
        echo $message;
       // return redirect('/clients')->with('mensaje', $mensaje);
    }

    public function destroy(Request $request,$id)
    {
        $userid = auth()->user()->id;
        \DB::update('update agl_client set client_deleted = 1, user_updated ='.$userid.' , deleted_at=CURRENT_TIMESTAMP where id = ' .$id);
        switch(app()->getLocale())
		{
            case("es"):
                $message = "Registro eliminado";
            break;
            case("en"):
                $message = "Delete successfully";
            break;
        }
        echo $message;
    }

    public function selectSearch(Request $request,$id=0)
    {
    	$data = [];
        $search = $request->q;
      
        $data = \DB::select("select id,name from agl_client where client_status=1 and name  like '%$search%'");
        
        $json = "";
        $total = count($data);
        $count=1;
        $comma = ",";
        foreach($data as $item)
        {
            $count++;
            if($count==$total)
            {
                $comma ="";
            }
            $json .="{";
            $json .='"id"'.':'.'"'.$item->id.'",';
            $json .='"brand"'.':'.'"'.$item->name.'"';
            $json .="}";
        }
        $languagesJSONObject = json_encode($data);
         
       // echo $languagesJSONObject;
        return  $data;
    }

    public function _create_btn($btnRSId, $btnType=1){

    }
}
