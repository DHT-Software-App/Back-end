<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalendarRequest;
use App\Http\Resources\CalendarResource;
use App\Http\Resources\CalendarCollection;
use App\Models\Calendar;
use App\Models\Job;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->middleware('able:view:calendars');
    }

    public function index()
    {
        $calendar = Calendar::paginate(15);

        return response()->json(new CalendarCollection($calendar), Response::HTTP_OK);
    }

    public function show(Calendar $calendar)
    {
        return response()->json(new CalendarResource($calendar), Response::HTTP_OK);
    }

    public function store(CalendarRequest $request)
    {
        $calendar = Calendar::create($request->validated());

        return response()->json(new CalendarResource($calendar), Response::HTTP_CREATED);
    }


    public function update(CalendarRequest $request, Calendar $calendar)
    {
        if ($calendar->update($request->validated())) {
            return response()->json(new CalendarResource($calendar), Response::HTTP_OK);
        }
    }

    public function delete(Calendar $calendar)
    {
        $calendar->delete();

        return response()->json([
            'success' => true,
            'message' => 'Calendar deleted successfully',
            'code' => 'DELETED'
        ], Response::HTTP_NO_CONTENT);
    }
}
