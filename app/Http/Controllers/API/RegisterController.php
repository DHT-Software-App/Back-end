<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FunctionsController;
use Illuminate\Support\Facades\Hash;
use Validator;

class RegisterController extends BaseController
{
    function activateUser ($codeActivate){
        
        $message = $this->sendResponse("Error", 'Broken link');
        $user_id = \DB::table('dry_users')->where('code_activation', $codeActivate)->first();

        if($user_id->block==1)
        {
            $userData = User::find($user_id->id);
            $userData->block = 0;
            $userData->save();
            $message = $this->sendResponse($userData, 'Account activate.');
        }
        return $message;
    
    }
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
   
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
       
        return $this->sendResponse($success, 'User register successfully.');
    }
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function loadUserEmail($email)
    {
        $functionGeneral = new FunctionsController();

        return $functionGeneral->loadDataUserByEmail($email);
    }
    public function login(Request $request){
      
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $loadData = $this->loadUserEmail($request->email);
            if($loadData->block==0)
            {
                $user = Auth::user(); 
                $success['id'] = $user->id;
                $success['token'] =  $user->createToken('MyApp')-> accessToken; 
                $success['first_use'] =  $user->first_use;
                $message = $this->sendResponse($success, 'User login successfully.');
            }else{
                $message = $this->sendError("Account block",  ['error'=>$loadData->lock_reason]);
            }

            return $message;
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
        
    }

    static function  insertNewUser($email,$userid,$origin)
    {

        $user =  User::create([
            'email'     =>  $email,
            'block'     =>  1,
            'photo'     => '',
            'access_system'=> 0,
            'first_use' => 1,
            'user_status' => 1,
            'user_deleted' => 0,
            'user_updated' => 0,
            'user_created' =>$userid,
            'role' => '2',
            'code_activation'=>  md5($email.rand()),
            'lock_reason' => 'We have sent you an email so you can activate your account please check your email',
            'password'  => Hash::make(12345678),
            'origin'  => $origin
          ]);
        
          return $user;
    }
}