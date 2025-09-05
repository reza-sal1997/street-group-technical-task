<?php

namespace App\Services;

use App\Contracts\PersonParserInterface;
use App\DTOs\PersonDTO;

class PersonNameParserService implements PersonParserInterface
{
    public function parse(string $nameStr): array
    {
        $people = [];

        // Normalize input
        $nameStr = $this->normalizeSeparators($nameStr);

        // If "and" exists, split into chunks
        if (stripos($nameStr, ' and ') !== false) {
            $chunks = explode(' and ', $nameStr);

            // If one side is just a title, treat as "shared surname" case
            if ($this->isSharedSurnameCase($chunks)) {
                return $this->parseSharedSurname($chunks);
            }

            // Otherwise, parse each person individually
            foreach ($chunks as $chunk) {
                $people = array_merge($people, $this->parseSinglePerson($chunk));
            }

            return $people;
        }

        return $this->parseSinglePerson($nameStr);
    }

    private function parseSinglePerson(string $nameStr): array
    {
        $parts = explode(' ', trim($nameStr));
        $people = [];

        $title = $parts[0];

        // Remove last element → surname
        $lastName = array_pop($parts);
//        noob bazi dar nayar agha ro ham hazf kon
        // The remaining words after the title
        $rest = array_slice($parts, 1);

        $firstName = null;
        $middleName   = null;
//        check kon title hazf shode bashe
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
