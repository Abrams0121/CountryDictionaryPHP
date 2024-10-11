<?php 

namespace App\Model;

interface CountryRepository {
    
    function getAll(): array;

    function getByAlpha2(string $code) : ?Country;

    function getByAlpha3(string $code) : ?Country;

    function getByNumeric(string $code) : ?Country;

    function store(Country $country) : void;

    function deleteAlpha2(string $code) : void;

    function deleteAlpha3(string $code) : void;

    function deleteNumeric(string $code) : void;

    function editAlpha2(Country $country,string $code) : void;

    function editAlpha3(Country $country,string $code) : void;

    function editNumeric(Country $country,string $code) : void;
}