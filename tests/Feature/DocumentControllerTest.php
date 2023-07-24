<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DocumentControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test document upload.
     */
    public function testUploadDocument()
    {
        Storage::fake('documents'); // Mock the storage for 'documents' disk

        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('document.pdf', 1000); // Create a fake PDF file

        $response = $this->actingAs($user)
            ->postJson('/api/upload', ['file' => $file]);

        $response->assertStatus(201)
            ->assertJson(['id' => 1]); // Assuming this is the first document uploaded
    }

    /**
     * Test document download.
     */
    public function testDownloadDocument()
    {
        Storage::fake('documents');

        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('document.pdf', 1000);

        $this->actingAs($user)
            ->postJson('/api/upload', ['file' => $file]);

        $documentId = 1; // Assuming this is the first document uploaded
        $response = $this->actingAs($user)
            ->get("/api/download/{$documentId}");

        $response->assertStatus(200);
    }

    /**
     * Test document index.
     */
    public function testDocumentIndex()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/api/documents')
            ->assertStatus(200)
            ->assertJsonStructure([
                'current_page',
                'total_pages',
                'data' => [
                    '*' => ['fileName', 'id'],
                ],
            ]);
    }
}
