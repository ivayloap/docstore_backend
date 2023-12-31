<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class DocumentController extends Controller
{
    protected $documentsService;

    public function __construct(DocumentsService $documentsService)
    {
        $this->documentsService = $documentsService;
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:50000',
        ]);

        $user = $request->user();
        $file = $request->file('file');

        $document = $this->documentsService->upload($file, $user->id);

        return response()->json(['id' => $document->id], 201);
    }

    public function download(Request $request, $id)
    {
        $user = $request->user();

        $document = $this->documentsService->download($id, $user->id);

        if (!$document) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $filePath = storage_path('app/' . $document->file_path);

        return response()->download($filePath, $document->name);
    }


    public function index(Request $request)
    {
        $user = $request->user(); // Access the authenticated user

        // Get the per_page and page parameters from the request or use default values
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        // Apply the default values if per_page or page is not provided or is not a positive integer
        $perPage = max(1, intval($perPage));
        $page = max(1, intval($page));

        // Get paginated documents for the authenticated user only
        $documents = Document::where('user_id', $user->id)->paginate($perPage, ['*'], 'page', $page);

        // Create the response JSON array
        $response = [
            'current_page' => $documents->currentPage(),
            'total_pages' => $documents->lastPage(),
            'data' => [],
        ];

        // Format each document for the data array
        foreach ($documents as $document) {
            $response['data'][] = [
                'fileName' => $document->name,
                'id' => $document->id,
            ];
        }

        return response()->json($response);
    }
}
