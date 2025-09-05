<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HomeownerImportControllerTest extends TestCase
{
    public function it_will_return_a_200_response_when_excel_file_exists(): void
    {
        // Arrange
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

        // Act
        $response = $this->postJson(route('homeowners.import'), [
            'file' => $file
        ]);

        // Assert
        $response->assertStatus(200);
    }

    public function test_it_returns_validation_error_response_when_required_field_is_missing(): void
    {
        // Act
        $response = $this->postJson(route('homeowners.import'));

        // Assert
        $response->assertStatus(422);
    }

    public function test_it_can_import_and_parse_homeowners_from_csv(): void
    {
        // Arrange
        Storage::fake('local');

        $csvContent = <<<CSV
homeowners
Prof Alex Brogan
Dr & Mrs Joe Bloggs
Mr Tom Staff and Mr John Doe
CSV;

        $file = UploadedFile::fake()->createWithContent('homeowners.csv', $csvContent);

        // Act
        $response = $this->postJson(route('homeowners.import'), [
            'file' => $file
        ]);

        $response->assertStatus(200);

        $responseData = $response->json();

        // Assert
        $this->assertCount(3, $responseData);

        $this->assertEquals('Prof', $responseData[0][0]['title']);
        $this->assertEquals('Alex', $responseData[0][0]['first_name']);
        $this->assertEquals(null, $responseData[0][0]['initial']);
        $this->assertEquals('Brogan', $responseData[0][0]['last_name']);

        $this->assertEquals('Dr', $responseData[1][0]['title']);
        $this->assertEquals(null, $responseData[1][0]['first_name']);
        $this->assertEquals(null, $responseData[1][0]['initial']);
        $this->assertEquals('Bloggs', $responseData[1][0]['last_name']);

        $this->assertEquals('Mrs', $responseData[1][1]['title']);
        $this->assertEquals('Joe', $responseData[1][1]['first_name']);
        $this->assertEquals(null, $responseData[1][1]['initial']);
        $this->assertEquals('Bloggs', $responseData[1][1]['last_name']);

        $this->assertEquals('Mr', $responseData[2][0]['title']);
        $this->assertEquals('Tom', $responseData[2][0]['first_name']);
        $this->assertEquals(null, $responseData[2][0]['initial']);
        $this->assertEquals('Staff', $responseData[2][0]['last_name']);

        $this->assertEquals('Mr', $responseData[2][1]['title']);
        $this->assertEquals('John', $responseData[2][1]['first_name']);
        $this->assertEquals(null, $responseData[2][1]['initial']);
        $this->assertEquals('Doe', $responseData[2][1]['last_name']);

    }
}
