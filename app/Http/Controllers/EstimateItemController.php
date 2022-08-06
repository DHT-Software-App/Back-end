<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstimateItemRequest;
use App\Http\Resources\EstimateItemCollection;
use App\Http\Resources\EstimateItemResource;
use App\Models\EstimateItem;
use Symfony\Component\HttpFoundation\Response;

class EstimateItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->middleware('able:view:estimateitems');
    }

    public function index()
    {
        $estimateItems = EstimateItem::all();

        return response()->json(new EstimateItemCollection($estimateItems), Response::HTTP_OK);
    }

    public function show(EstimateItem $estimateItem)
    {
        return response()->json(new EstimateItemResource($estimateItem), Response::HTTP_OK);
    }

    public function store(EstimateItemRequest $request)
    {
        $estimateItem = EstimateItem::create($request->validated());

        return response()->json(new EstimateItemResource($estimateItem), Response::HTTP_CREATED);
    }


    public function update(EstimateItemRequest $request, EstimateItem $estimateItem)
    {
        // update estimate item after confirming action completed
        if ($estimateItem->update($request->validated())) {
            return response()->json(new EstimateItemResource($estimateItem), Response::HTTP_OK);
        }
    }

    public function delete(EstimateItem $estimateItem)
    {

        // // delete estimate item
        $estimateItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Estimate Item deleted successfully',
            'code' => 'DELETED'
        ], Response::HTTP_NO_CONTENT);
    }
}
