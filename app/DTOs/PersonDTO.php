<?php
declare(strict_types=1);

namespace App\DTOs;

class PersonDTO
{
    public function __construct(
        public string $title,
        public ?string $first_name,
        public ?string $initial,
        public string $last_name
    ) {}

    public function toArray(): array
    {
        return [
            'title'      => $this->title,
            'first_name' => $this->first_name,
            'initial'    => $this->initial,
            'last_name'  => $this->last_name,
        ];
    }
}
