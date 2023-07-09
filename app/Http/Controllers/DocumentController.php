<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class DocumentController extends Controller
{
    public function upload(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $file = $request->file('file');
        $filename = $file->getClientOriginalName();

        $filePath = $file->storeAs('documents', $filename);

        $document = new Document;
        $document->name = $filename;
        $document->file_path = $filePath;
        $document->user_id = $user->id;
        $document->save();

        return response()->json(['id' => $document->id], 201);
    }

    public function download(Request $request, $id)
    {
        $user = $request->user(); // Access the authenticated user

        $document = Document::findOrFail($id);

        if($user->id != $document->user_id){
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $filePath = storage_path('app/' . $document->file_path);

        return response()->download($filePath, $document->name);
    }

}
