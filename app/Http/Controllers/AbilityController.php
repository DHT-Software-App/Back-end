<?php

namespace App\Http\Controllers;

use App\Http\Resources\AbilityCollection;
use App\Http\Resources\AbilityResource;
use App\Models\Employee;
use Symfony\Component\HttpFoundation\Response;

class AbilityController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => []]);
        $this->middleware('able:view:employees');
    }

    // route: /api/v1/employees/{employee}/abilities
    public function index(Employee $employee) {
        // find assigned role
        $ownedRole = $employee->getRoles()->first();

        //  find ability by id
        $abilities = $employee->getAbilities();

        $not_found_entity = 'Abilities';
        
        // verify that role and ability exist
        if($ownedRole && $abilities) {
            // calling policy
            $this->authorize('view',[Ability::class, $ownedRole]);

            return response()->json(new AbilityCollection($abilities), Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => "{$not_found_entity} Not Found"
        ], Response::HTTP_NOT_FOUND);
    }

    // route: /api/v1/employees/{employee}/abilities/{ability}
    public function show(Employee $employee, $ability) {
        // find assigned role
        $ownedRole = $employee->getRoles()->first();

        //  find ability by id
        $ability = $employee->getAbilities()->find($ability);

        $not_found_entity = 'Ability';
        
        // verify that role and ability exist
        if($ownedRole && $ability) {
            // calling policy
            $this->authorize('view',[Ability::class, $ownedRole]);

            return response()->json(new AbilityResource($ability), Response::HTTP_OK);
        }

       
        return response()->json([
            'success' => false,
            'message' => "{$not_found_entity} Not Found"
        ], Response::HTTP_NOT_FOUND);
    }
}
