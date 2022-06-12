<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class FunctionsController extends Controller
{
   function validateCamps($request,$camps){
    $input = $request->all();
    $validator = Validator::make($input, $camps);

    return $validator;
   }

   public function loadDataUserByEmail($email)
   {
       $userData = new UserController();
       $idUser = $userData->readEmail($email);

       return $idUser;
   }
   
}