<?php

namespace App\Http\Controllers;


use App\Http\Requests\DocumentTypeRequest;
use App\Http\Resources\DocumentTypeCollection;
use App\Http\Resources\DocumentTypeResource;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DocumentTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->middleware('able:view:documenttypes');
    }

    public function index()
    {
        $document = DocumentType::paginate(15);

        return response()->json(new DocumentTypeCollection($document), Response::HTTP_OK);
    }

    public function show(DocumentType $documentType)
    {
        return response()->json(new DocumentTypeResource($documentType), Response::HTTP_OK);
    }

    public function store(DocumentTypeRequest $request)
    {
        $document = DocumentType::create($request->validated());

        return response()->json(new DocumentTypeResource($request), Response::HTTP_CREATED);
    }


    public function update(DocumentTypeRequest $request, DocumentType $document)
    {
        if ($document->update($request->validated())) {
            return response()->json(new DocumentTypeResource($document), Response::HTTP_OK);
        }
    }

    public function delete(DocumentTypeRequest $document)
    {
        $document->delete();

        return response()->json([
            'success' => true,
            'message' => 'Document Type deleted successfully',
            'code' => 'DELETED'
        ], Response::HTTP_NO_CONTENT);
    }
}
