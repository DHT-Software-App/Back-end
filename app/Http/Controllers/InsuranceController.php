<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsuranceRequest;
use App\Http\Resources\InsuranceCollection;
use App\Http\Resources\InsuranceResource;
use App\Models\Insurance;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InsuranceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->middleware('able:view:insurances');
    }

    public function index()
    {
        $insurances = Insurance::all();

        return response()->json(new InsuranceCollection($insurances), Response::HTTP_OK);
    }

    public function show(Insurance $insurance)
    {
        return response()->json(new InsuranceResource($insurance), Response::HTTP_OK);
    }

    public function store(InsuranceRequest $request)
    {
        $insurance = Insurance::create($request->validated());

        return response()->json(new InsuranceResource($insurance), Response::HTTP_CREATED);
    }


    public function update(InsuranceRequest $request, Insurance $insurance)
    {
        // update insurance after confirming action completed
        if ($insurance->update($request->validated())) {
            return response()->json(new InsuranceResource($insurance), Response::HTTP_OK);
        }
    }

    public function delete(Insurance $insurance)
    {

        // // delete employee
        $insurance->delete();

        return response()->json([
            'success' => true,
            'message' => 'Insurance Company deleted successfully',
            'code' => 'DELETED'
        ], Response::HTTP_NO_CONTENT);
    }
}
