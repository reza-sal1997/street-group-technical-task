<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\HomeownerImportRequest;
use Tests\TestCase;

class UpdateProductsRequestTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_the_correct_validation_rules(): void
    {
        // Arrange
        $request = new HomeownerImportRequest();
        $rules = $request->rules();

        // Act & Assert
        $this->assertEquals([
            'file' => 'required|file|extensions:csv|max:2048',
        ], $rules);
    }

    /**
     * @test
     */
    public function it_authorizes_the_request(): void
    {
        // Arrange
        $request = new HomeownerImportRequest();

        // Act & Assert
        $this->assertTrue($request->authorize(), 'The request should be authorized.');
    }
}
