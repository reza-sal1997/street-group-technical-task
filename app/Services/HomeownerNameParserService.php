<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\PersonParserInterface;
use App\DTOs\PersonDTO;

class HomeownerNameParserService implements PersonParserInterface
{
    public function parse(string $name): array
    {
        $people = [];

        // Normalize input
        $name = $this->normalizeSeparators($name);

        // If there is "and" in the string, split into chunks
        if (stripos($name, ' and ') !== false) {
            $chunks = explode(' and ', $name);

            // If one side is just a title, the names share same surname
            if ($this->isSharedSurnameCase($chunks)) {
                return $this->parseSharedSurname($chunks);
            }

            // Otherwise, parse each person individually
            foreach ($chunks as $chunk) {
                $people = array_merge($people, $this->parseSinglePerson($chunk));
            }

            return $people;
        }

        return $this->parseSinglePerson($name);
    }

    private function parseSinglePerson(string $name): array
    {
        $people = [];

        $segmentWords = explode(' ', trim($name));
        $title = $segmentWords[0];

        // Remove the surname from the segment
        $lastName = array_pop($segmentWords);

        // Remaining words after the title
        $rest = array_slice($segmentWords, 1);

        $firstName = null;
        $middleName   = null;
        if (!empty($rest)) {
            if (count($rest) === 1) {
                $firstName = $rest[0];
            } else {
                $firstName = $rest[0];
                $middleName = $rest[1];
            }
        }

        $people[] = new PersonDTO($title, $firstName, $middleName, $lastName);
        return $people;
    }

    private function parseSharedSurname(array $nameSegments): array
    {
        $people = [];

        // Extract surname from last segment
        $lastSegmentWords = explode(' ', trim(end($nameSegments)));
        $lastName = array_pop($lastSegmentWords); // remove surname

        // Replace the last segment without the surname
        array_pop($nameSegments); // drop old last segment
        $nameSegments[] = implode(' ', $lastSegmentWords);

        foreach ($nameSegments as $segment) {
                $segmentWords = explode(' ', trim($segment));
                $title = $segmentWords[0];
                $firstName = $segmentWords[1] ?? null;
                $middleName = $segmentWords[2] ?? null;
                $people[] = new PersonDTO($title, $firstName, $middleName, $lastName);
        }
        return $people;
    }

    private function normalizeSeparators(string $name): string
    {
        $name = str_replace("&", " and ", $name);

        return preg_replace('/\s+/', ' ', trim($name));
    }

    // Here are some examples that this function returns true: Dr & Mrs John Doe, Dr and Mrs John Doe, Mr and Mrs Doe, Mr & Mrs Doe
    private function isSharedSurnameCase(array $nameSegments): bool
    {
        foreach ($nameSegments as $segment) {
            $words = explode(' ', trim($segment));
            if (count($words) === 1) {
                return true;
            }
        }

        return false;
    }
}
