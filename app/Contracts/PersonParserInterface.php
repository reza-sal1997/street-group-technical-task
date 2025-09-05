<?php

declare(strict_types=1);

namespace App\Contracts;

interface PersonParserInterface
{
    /**
     * Parse a homeowner string names into an array of people DTO.
     *
     * @param string $homeOwnerNames
     * @return array
     */
    public function parse(string $homeOwnerNames): array;
}
