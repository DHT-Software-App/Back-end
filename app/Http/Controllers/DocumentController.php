<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Http\Resources\DocumentCollection;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Spatie\QueryBuilder\QueryBuilder;

class DocumentController extends Controller
{
    private $folder = 'documents';

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->middleware('able:view:documents');
    }

    public function index()
    {
        $fields = \Schema::getColumnListing('documents');

        $documents = QueryBuilder::for(Document::class)
            ->allowedFilters($fields)
            ->allowedSorts($fields)
            ->paginate(15)
            ->appends(request()->query());

        return new DocumentCollection($documents);
    }

    public function show(Document $document)
    {
        return response()->json(new DocumentResource($document), Response::HTTP_OK);
    }

    public function store(DocumentRequest $request)
    {
        $document = Document::create($request->validated());

        if ($document) {
            if ($image = $request->url) {
                $this->saveRelatedImage($this->folder, $image, $document);
            }
        }

        return response()->json(new DocumentResource($document), Response::HTTP_CREATED);
    }


    public function update(DocumentRequest $request, Document $document)
    {
        if ($document->update($request->validated())) {
            if ($image = $request->url) {
                $this->saveRelatedImage($this->folder, $image, $document);
            }

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

    public function saveRelatedImage($folder, $image, $owner_model)
    {
        $path = Storage::disk('s3')->put($folder, $image, 'public');

        $owner_model->image()->updateOrCreate([
            'imageable_id' => $owner_model->id
        ], [
            'url' => $path,
            'size' => $image->getSize(),
            'extension' => $image->extension()
        ]);
    }
}
