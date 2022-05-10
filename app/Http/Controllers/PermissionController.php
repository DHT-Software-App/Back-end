<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function index($user) {
        $user = User::find($user);

        if($user) {
            $permissions = $user->getAllPermissions();

            return response()->json(new PermissionCollection($permissions), Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'Resource Not Found'
        ], Response::HTTP_NOT_FOUND);
    }
}
