<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class SeriesFormDto {
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 5)]
        public string $name = '',

        #[Assert\NotBlank]
        #[Assert\GreaterThanOrEqual(value: 1)]
        public int $seasonsQuantity = 0,

        #[Assert\NotBlank]
        #[Assert\GreaterThanOrEqual(value: 1)]
        public int $episodesPerSeason = 0
    )
    {
    }
}
