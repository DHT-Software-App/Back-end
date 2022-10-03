<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkTypeRequest;
use App\Http\Resources\WorkTypeCollection;
use App\Http\Resources\WorkTypeResource;
use App\Models\WorkType;
use Symfony\Component\HttpFoundation\Response;
use Spatie\QueryBuilder\QueryBuilder;

class WorkTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->middleware('able:view:worktypes');
    }

    public function index()
    {
        $fields = \Schema::getColumnListing('work_types');

        $workTypes = QueryBuilder::for(WorkType::class)
            ->allowedFilters($fields)
            ->allowedSorts($fields)
            ->paginate(15)
            ->appends(request()->query());


        return new WorkTypeCollection($workTypes);
    }

    public function show(WorkType $workType)
    {
        return response()->json(new WorkTypeResource($workType), Response::HTTP_OK);
    }

    public function store(WorkTypeRequest $request)
    {
        $workType = WorkType::create($request->validated());

        return response()->json(new WorkTypeResource($workType), Response::HTTP_CREATED);
    }


    public function update(WorkTypeRequest $request, WorkType $workType)
    {
        // update workType after confirming action completed
        if ($workType->update($request->validated())) {
            return response()->json(new WorkTypeResource($workType), Response::HTTP_OK);
        }
    }

    public function delete(WorkType $workType)
    {

        // // delete work type
        $workType->delete();

        return response()->json([
            'success' => true,
            'message' => 'Work Type deleted successfully',
            'code' => 'DELETED'
        ], Response::HTTP_NO_CONTENT);
    }
}
