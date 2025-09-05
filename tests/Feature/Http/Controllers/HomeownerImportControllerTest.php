<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HomeownerImportControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_import_and_parse_homeowners_from_csv()
    {
        // Fake the storage
        Storage::fake('local');

        // Create a CSV content
        $csvContent = <<<CSV
Title Name
Dr John Doe
Mr and Mrs Smith
Ms Jane & Emily Johnson
CSV;

        // Create a fake CSV file
        $file = UploadedFile::fake()->createWithContent('homeowners.csv', $csvContent);

        // Send a POST request to your import route
        $response = $this->postJson(route('homeowners.import'), [
            'file' => $file
        ]);

        $response->assertStatus(200);

        $responseData = $response->json();

        // Assertions
        $this->assertCount(5, $responseData); // 1 + 2 + 2 = 5 people parsed

        $this->assertEquals('Dr', $responseData[0]['title']);
        $this->assertEquals('John', $responseData[0]['firstName']);
        $this->assertEquals(null, $responseData[0]['middleName']);
        $this->assertEquals('Doe', $responseData[0]['lastName']);

        $this->assertEquals('Mr', $responseData[1]['title']);
        $this->assertEquals('Smith', $responseData[1]['lastName']); // shared surname

        $this->assertEquals('Mrs', $responseData[2]['title']);
        $this->assertEquals('Smith', $responseData[2]['lastName']); // shared surname

        $this->assertEquals('Ms', $responseData[3]['title']);
        $this->assertEquals('Jane', $responseData[3]['firstName']);
        $this->assertEquals('Johnson', $responseData[3]['lastName']);

        $this->assertEquals('Emily', $responseData[4]['firstName']);
        $this->assertEquals('Johnson', $responseData[4]['lastName']);
    }
}
