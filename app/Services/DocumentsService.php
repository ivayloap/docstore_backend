namespace App\Services;

use App\Models\Document;
use Illuminate\Http\UploadedFile;

class DocumentsService
{
    public function upload(UploadedFile $file, $userId)
    {
        $filename = $file->getClientOriginalName();
        $filePath = $file->storeAs('documents', $filename);

        $document = new Document;
        $document->name = $filename;
        $document->file_path = $filePath;
        $document->user_id = $userId;
        $document->save();

        return $document;
    }

    public function download($documentId, $userId)
    {
        $document = Document::findOrFail($documentId);

        if ($userId != $document->user_id) {
            return null; // Or throw an exception or return an error response
        }

        return $document;
    }
}
