<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function index() {
        $users = User::all();

        return response()->json(new UserCollection($users));
    }

    public function show(Employee $employee, $user) {
        $user = $employee->user->find($user);

        if($user) {
            return response()->json(new UserResource($user), Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'User Not Found'
        ], Response::HTTP_NOT_FOUND);
    }
}
