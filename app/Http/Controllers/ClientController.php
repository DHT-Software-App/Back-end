<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Http\Resources\ClientCollection;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Symfony\Component\HttpFoundation\Response;
use Spatie\QueryBuilder\QueryBuilder;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->middleware('able:view:clients');
    }

    public function index()
    {
        $fields = \Schema::getColumnListing('clients');

        $clients = QueryBuilder::for(Client::class)
            ->allowedFilters($fields)
            ->allowedSorts($fields)
            ->paginate(15)
            ->appends(request()->query());

        return new ClientCollection($clients);
    }

    public function show(Client $client)
    {
        return response()->json(new ClientResource($client), Response::HTTP_OK);
    }

    public function store(ClientRequest $request)
    {
        $client = Client::create($request->validated());

        return response()->json(new ClientResource($client), Response::HTTP_CREATED);
    }


    public function update(ClientRequest $request, Client $client)
    {
        // update client after confirming action completed
        if ($client->update($request->validated())) {
            return response()->json(new ClientResource($client), Response::HTTP_OK);
        }
    }

    public function delete(Client $client)
    {

        // // delete client
        $client->delete();

        return response()->json([
            'success' => true,
            'message' => 'Client deleted successfully',
            'code' => 'DELETED'
        ], Response::HTTP_NO_CONTENT);
    }
}
