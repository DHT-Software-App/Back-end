<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Symfony\Component\HttpFoundation\Response;
use Spatie\QueryBuilder\QueryBuilder;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->middleware('able:view:customers');
    }

    public function index()
    {
        $fields = \Schema::getColumnListing('customers');

        $customers = QueryBuilder::for(Customer::class)
            ->allowedFilters($fields)
            ->allowedSorts($fields)
            ->paginate(15)
            ->appends(request()->query());

        return new CustomerCollection($customers);
    }

    public function show(Customer $customer)
    {

        return response()->json(new CustomerResource($customer), Response::HTTP_OK);
    }

    public function store(CustomerRequest $request)
    {
        $customer = Customer::create($request->validated());

        return response()->json(new CustomerResource($customer), Response::HTTP_CREATED);
    }


    public function update(CustomerRequest $request, Customer $customer)
    {
        // update client after confirming action completed
        if ($customer->update($request->validated())) {
            return response()->json(new CustomerResource($customer), Response::HTTP_OK);
        }
    }

    public function delete(Customer $customer)
    {

        // // delete customer
        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer deleted successfully',
            'code' => 'DELETED'
        ], Response::HTTP_NO_CONTENT);
    }
}
