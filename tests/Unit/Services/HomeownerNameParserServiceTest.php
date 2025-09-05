<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\DTOs\PersonDTO;
use App\Services\HomeownerNameParserService;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class HomeownerNameParserServiceTest extends TestCase
{
    #[DataProvider('nameProvider')]
    public function test_it_parses_various_name_strings_correctly(string $nameStr, array $expected): void
    {
        // Arrange
        $parser = new HomeownerNameParserService();

        // Act
        $result = $parser->parse($nameStr);

        // Assert
        $this->assertCount(count($expected), $result);

        foreach ($expected as $index => $expectedPerson) {
            $this->assertEquals(
                $expectedPerson,
                $result[$index]
            );
        }
    }

    public static function nameProvider(): array
    {
        return [
            'single person' => [
                'nameStr' => 'Mr John Doe',
                'expected' => [new PersonDTO('Mr', 'John', null, 'Doe')],
            ],
            'single person with middle name' => [
                'nameStr' => 'Mrs Jane F Smith',
                'expected' => [new PersonDTO('Mrs', 'Jane', 'F', 'Smith')],
            ],
            'two separate people with and' => [
                'nameStr' => 'Mr John Doe and Mrs Jane Smith',
                'expected' => [
                    new PersonDTO('Mr', 'John', null, 'Doe'),
                    new PersonDTO('Mrs', 'Jane', null, 'Smith'),
                ],
            ],
            'two separate people with ampersand' => [
                'nameStr' => 'Mr John Doe & Mrs Jane Smith',
                'expected' => [
                    new PersonDTO('Mr', 'John', null, 'Doe'),
                    new PersonDTO('Mrs', 'Jane', null, 'Smith'),
                ],
            ],
            'shared surname with titles only' => [
                'nameStr' => 'Mr and Mrs Smith',
                'expected' => [
                    new PersonDTO('Mr', null, null, 'Smith'),
                    new PersonDTO('Mrs', null, null, 'Smith'),
                ],
            ],
            'shared surname with ampersand' => [
                'nameStr' => 'Dr & Mrs John Doe',
                'expected' => [
                    new PersonDTO('Dr', null, null, 'Doe'),
                    new PersonDTO('Mrs', 'John', null, 'Doe'),
                ],
            ],
            'extra whitespace normalization' => [
                'nameStr' => '  Mr   John    Doe  ',
                'expected' => [new PersonDTO('Mr', 'John', null, 'Doe')],
            ],
            'single title and name' => [
                'nameStr' => 'Dr Smith',
                'expected' => [new PersonDTO('Dr', null, null, 'Smith')]
            ]
        ];
    }
}
