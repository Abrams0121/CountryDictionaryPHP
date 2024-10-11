<?php

namespace App\Model;

// Country - класс страны
class Country {
	
    public function __construct(
        public string $shortName,
        public ?string $fullName = null,
        public string $isoAlpha2,
        public string $isoAlpha3,
        public string $isoNumeric,
        public int $population,
        public float $square
    )
    {
        
    }
}
