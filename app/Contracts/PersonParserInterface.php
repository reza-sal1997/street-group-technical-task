<?php

namespace App\Contracts;

interface PersonParserInterface
{
    /**
     * Parse a homeowner string names into an array of people.
     *
     * @param string $homeOwnerNames
     * @return array
     */
    public function parse(string $homeOwnerNames): array;
}
