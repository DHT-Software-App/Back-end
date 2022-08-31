<?php

namespace App\Http\Controllers;


use App\Http\Requests\DocumentRequest;
use App\Http\Resources\DocumentCollection;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->middleware('able:view:document');
    }

    public function index()
    {
        $document = Document::all();

        return response()->json(new DocumentCollection($document), Response::HTTP_OK);
    }

    public function show(Document $document)
    {
        return response()->json(new DocumentResource($document), Response::HTTP_OK);
    }

    public function store(DocumentRequest $request)
    {
        $document = Document::create($request->validated());

        return response()->json(new DocumentResource($document), Response::HTTP_CREATED);
    }


    public function update(DocumentRequest $request, Document $document)
    {
        if ($document->update($request->validated())) {
            return response()->json(new DocumentResource($document), Response::HTTP_OK);
        }
    }

    public function delete(Document $document)
    {
        $document->delete();

        return response()->json([
            'success' => true,
            'message' => 'Document deleted successfully',
            'code' => 'DELETED'
        ], Response::HTTP_NO_CONTENT);
    }
}
