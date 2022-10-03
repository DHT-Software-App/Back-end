<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Http\Resources\JobResource;
use App\Http\Resources\JobCollection;
use App\Models\Job;
use Symfony\Component\HttpFoundation\Response;
use Spatie\QueryBuilder\QueryBuilder;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->middleware('able:view:jobs');
    }

    public function index()
    {
        $fields = \Schema::getColumnListing('jobs');

        $jobs = QueryBuilder::for(Job::class)
            ->allowedFilters($fields)
            ->allowedSorts($fields)
            ->paginate(15)
            ->appends(request()->query());

        return new JobCollection($jobs);
    }

    public function show(Job $job)
    {
        return response()->json(new JobResource($job), Response::HTTP_OK);
    }

    public function store(JobRequest $request)
    {
        $job = Job::create($request->validated());

        return response()->json(new JobResource($job), Response::HTTP_CREATED);
    }


    public function update(JobRequest $request, Job $job)
    {
        if ($job->update($request->validated())) {
            return response()->json(new JobResource($job), Response::HTTP_OK);
        }
    }

    public function delete(Job $job)
    {
        $job->delete();

        return response()->json([
            'success' => true,
            'message' => 'Job deleted successfully',
            'code' => 'DELETED'
        ], Response::HTTP_NO_CONTENT);
    }
}
