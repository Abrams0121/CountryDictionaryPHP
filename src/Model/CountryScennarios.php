<?php

namespace App\Model;

use Exception;

use App\Rdb\CountryStorage;
use Symfony\Component\Intl\Countries;
use App\Model\Exceptions\InvalidISOCodeException;
use App\Model\Exceptions\CountryNotFoundException;
use App\Model\Exceptions\DuplicatedCodeException;
use App\Model\Exceptions\InvalidValueException;
use App\Model\Exceptions\CodeCollisionException;

class CountryScenarios {
    
    public function __construct(
        private readonly CountryStorage $storage
    ) {
        
    }

    public function getAll(): array {
        return $this->storage->getAll();
    }

    public function getByCode(string $code) : Country
    {
        if (strlen($code) === 2) {
            if ($this->validateISOAlpha2($code)) {
                $country = $this->storage->getByAlpha2($code);
            } 
            else throw new InvalidISOCodeException($code, 'ISOAlpha2 validation failed');
        } 
        else if (strlen($code) === 3) {
            if ($this->validateISOAlpha3($code)) {
                $country = $this->storage->getByAlpha3($code);
            }
            else throw new InvalidISOCodeException($code, 'ISOAlpha3 validation failed');
        }
        else if (ctype_digit($code)) {
            if ($this->validateISONumeric($code)) {
                $country = $this->storage->getByNumeric($code);
            }
            else throw new InvalidISOCodeException($code, 'ISONumeric validation failed');
        }
        else {
            throw new InvalidISOCodeException($code, 'invalid ISO code');
        }

        if ($country === null) {
            throw new CountryNotFoundException($code);
        }

        return $country;
    }

    public function store(Country $country) : void {
        
        if (!isset($country->fullName)) {
            throw new InvalidValueException($country->fullName, 'fullName validation failed');
        }
        
        if (!isset($country->shortName) &&  strlen($country->shortName) == 0) {
            throw new InvalidValueException($country->shortName, 'shortName validation failed');
        }


        if (!isset($country->population) && $country->population < 0) {
            throw new InvalidValueException($country->population, 'population validation failed');
        }

        if (!isset($country->square) && $country->square < 0) {
            throw new InvalidValueException($country->square, 'square validation failed');
        }

        if (!isset($country->isoAlpha2) || !$this->validateISOAlpha2($country->isoAlpha2)) {
            throw new InvalidISOCodeException($country->isoAlpha2, 'ISOAlpha2 validation failed');
        }

        if (!isset($country->isoAlpha3) ||  !$this->validateISOAlpha3($country->isoAlpha3)) {
            throw new InvalidISOCodeException($country->isoAlpha3, 'isoAlpha3 validation failed');
        }

        if (!isset($country->isoNumeric) ||  !$this->validateISONumeric($country->isoNumeric)) {
            throw new InvalidISOCodeException($country->isoNumeric, 'isoNumeric validation failed');
        }
        
        $duplicateCode = $this->isThisExsist($country);
        if ($duplicateCode != null) {
            throw new DuplicatedCodeException(duplicatedCode: $duplicateCode);
        }
        
        $this->storage->store(country: $country);
    }

    public function edit(Country $country,string $code) : void {

        if (!isset($country->fullName)) {
            throw new InvalidValueException($country->fullName, 'fullName validation failed');
        }
        
        if (!isset($country->shortName) &&  strlen($country->shortName) == 0) {
            throw new InvalidValueException($country->shortName, 'shortName validation failed');
        }


        if (!isset($country->population) && $country->population < 0) {
            throw new InvalidValueException($country->population, 'population validation failed');
        }

        if (!isset($country->square) && $country->square < 0) {
            throw new InvalidValueException($country->square, 'square validation failed');
        }

        if (!isset($country->isoAlpha2) || !$this->validateISOAlpha2($country->isoAlpha2)) {
            throw new InvalidISOCodeException($country->isoAlpha2, 'edit ISOAlpha2 validation failed');
        }

        if (!isset($country->isoAlpha3) ||  !$this->validateISOAlpha3($country->isoAlpha3)) {
            throw new InvalidISOCodeException($country->isoAlpha3, 'edit isoAlpha3 validation failed');
        }

        if (!isset($country->isoNumeric) ||  !$this->validateISONumeric($country->isoNumeric)) {
            throw new InvalidISOCodeException($country->isoNumeric, 'edit isoNumeric validation failed');
        }

        if (strlen($code) === 2) {
            if ($this->validateISOAlpha2($code)) {
                $oldCountry = $this->storage->getByAlpha2($code);
                if ($oldCountry === null) {
                    throw new CountryNotFoundException($code);
                }
                if (!$this->isCodesAreTheSame($country->isoAlpha2,$oldCountry->isoAlpha2)) {
                    throw new CodeCollisionException();
                }
                $this->storage->editAlpha2($country,$code);
            } 
            else throw new InvalidISOCodeException($code, 'ISOAlpha2 validation failed');
        } 
        else if (strlen($code) === 3) {
            if ($this->validateISOAlpha3($code)) {
                $oldCountry = $this->storage->getByAlpha3($code);
                if ($oldCountry === null) {
                    throw new CountryNotFoundException($code);
                }
                if (!$this->isCodesAreTheSame($country->isoAlpha3,$oldCountry->isoAlpha3)) {
                    throw new CodeCollisionException();
                }
                $this->storage->editAlpha3($country,$code);
            }
            else throw new InvalidISOCodeException($code, 'ISOAlpha3 validation failed');
        }
        else if (ctype_digit($code)) {
            if ($this->validateISONumeric($code)) {
                $oldCountry = $this->storage->getByNumeric($code);
                if ($oldCountry === null) {
                    throw new CountryNotFoundException($code);
                }
                if (!$this->isCodesAreTheSame($country->isoNumeric,$oldCountry->isoNumeric)) {
                    throw new CodeCollisionException();
                }
                $this->storage->editNumeric($country,$code);
            }
            else throw new InvalidISOCodeException($code, 'ISONumeric validation failed');
        }
        else {
            throw new InvalidISOCodeException($code, 'invalid ISO code');
        }
    }

    public function delete(string $code) : void {
        if (strlen($code) === 2) {
            if ($this->validateISOAlpha2($code)) {
                $country = $this->storage->getByAlpha2($code);
                if (!isset($country)) {
                    throw new CountryNotFoundException($code);
                }
                $this->storage->editAlpha2($country,$code);
            } 
            
            else throw new InvalidISOCodeException($code, 'ISOAlpha2 validation failed');
        } 
        else if (strlen($code) === 3) {
            if ($this->validateISOAlpha3($code)) {
                $country = $this->storage->getByAlpha3($code);
                if (!isset($country)) {
                    throw new CountryNotFoundException($code);
                }
                $this->storage->editAlpha3($country,$code);
            }
            else throw new InvalidISOCodeException($code, 'ISOAlpha3 validation failed');
        }
        else if (ctype_digit($code)) {
            if ($this->validateISONumeric($code)) {
                $country = $this->storage->getByNumeric($code);
                if (!isset($country)) {
                    throw new CountryNotFoundException($code);
                }
                $this->storage->editAlpha3($country,$code);
            }
            else throw new InvalidISOCodeException($code, 'ISONumeric validation failed');
        }
        else {
            throw new InvalidISOCodeException($code, 'invalid ISO code');
        }
    }

    private function validateISOAlpha2(string $code): bool {
        return Countries::exists($code);
    }

    private function validateISOAlpha3(string $code): bool {
        $allAlpha3Codes = array_values(Countries::getAlpha3Codes());
        return in_array(strtoupper($code), $allAlpha3Codes);
    }

    private function validateISONumeric(string $code): bool {
        $allNumericCodes = array_values(Countries::getNumericCodes());
        return in_array($code, $allNumericCodes);
    }

    private function isThisExsist(Country $country) : ?string {
        $country1 = $this->storage->getByAlpha2($country->isoAlpha2);
        $country2 = $this->storage->getByAlpha3($country->isoAlpha2);
        $country3 = $this->storage->getByNumeric($country->isoAlpha2);

        if (isset($country1))
        {
            return $country->isoAlpha2;
        }
        elseif (isset($country2))
        {
            return $country->isoAlpha2;
        }
        elseif (isset($country3))
        {
            return $country->isoAlpha2;
        }
        return null;
    }

    private function isCodesAreTheSame(string $oldCode,string $newCode) : bool {
        if ($oldCode === $newCode) {
            return true;
        }
        return false;
    }
}