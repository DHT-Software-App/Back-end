<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use DataTables;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index()
    {
      $users = User::whereHas('roles', function($query){
                $query->where('name', 'user');
              })->get();

      return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::get(['id', 'name']);
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $user = User::create([
                  'email'     =>  $request->email,
                  'block'     =>  1,
                  'photo'     => '',
                  'access_system'=> 1,
                  'first_use' => 1,
                  'user_status' => 1,
                  'user_deleted' => 0,
                  'user_updated' => 0,
                  'user_created' => auth()->user()->id,
                  'role' => '0',
                  'code_activation'=> md5($request->email.rand()),
                  'lock_reason' => 'We have sent you an email so you can activate your account, please check your email',
                  'password'  =>  Hash::make($request->password),
                  'origin' => ''
                ]);

        $user->assignRole($request->input('roles'));

        //return redirect()->route('users.index')->with('success', 'User created succssfully.');
    }

    public function readEmail($email)
    {
        $user_id = \DB::table('dry_users')->where('email', $email)->first();
      //  $this->show($user_id);
      return $user_id;
    }

    public function show($id)
    {
        $user = User::find($id);
        $roles = Role::get(['id', 'name']);
        $userRoles = $user->roles->pluck('id')->toArray();

        return view('admin.users.show', compact('user', 'roles', 'userRoles'));

        if (is_null($user)) {
            return $this->sendError('Customers not found.');
        }
        return $this->sendResponse(new UserResource($user), 'Costumers retrieved successfully.');
    }

    public function update(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $user->update(['name' => $request->name]);
        $user->syncRoles($request->input('roles'));

        return redirect()->route('users.index')->with('success', 'User updated succssfully.');
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');

    }

     //Load datatable
     public function loadDatatable(Request $request)
     {
            $data = \DB::select("SELECT id,email,role FROM dry_users
            where user_deleted=0");
             return Datatables::of($data)
             ->addColumn('action', function($row){
                 $btn = '
                 
                 <div class="dropdown">
                     <a href="javascript:void(0);" class="btn btn-sm btn-light btn-active-light-primary  dropdown-toggle lastend" data-bs-toggle="dropdown"><i class="las la-cog size-25"></i></a>
                     <div class="dropdown-menu">
                         <a href="javascript:void(0);" user-id="'.$row->id.'" class="dropdown-item user-modal">'.__('View').'</a>
                         <a href="javascript:void(0);" user-id="'.$row->id.'" data-token="{{ csrf_token() }}" class="dropdown-item user-delete">'.__('Delete').'</a>
                     </div>
                 </div>
                 ';
   
                         return $btn;
                 })
            
                     ->rawColumns(['action'])
                     ->make(true);
         
     }
}
