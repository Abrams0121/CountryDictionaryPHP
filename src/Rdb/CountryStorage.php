<?php

namespace App\Rdb;

use App\Rdb\SqlHelper;
use App\Model\Country;
use App\Model\CountryRepository;
use Exception;

class CountryStorage implements CountryRepository {
    

    public function __construct(
        private readonly SqlHelper $sqlHelper
    ){}

    public function getAll(): array {
        try {
            // создать подключение к БД
            $connection = $this->sqlHelper->openDbConnection();
            // подготовить строку запроса
            $queryStr = '
                SELECT shortName,fullName,isoAlpha2,isoAlpha3,isoNumeric,population,square 
                FROM country_t;';
            // выполнить запрос
            $rows = $connection->query(query: $queryStr);
            // считать результаты запроса в цикле 
            $countries = [];
            while ($row = $rows->fetch_array()) {
                // каждая строка считается в тип массива
                $country = new Country(
                    shortName: $row[0],
                    fullName: $row[1],
                    isoAlpha2: $row[2],
                    isoAlpha3: $row[3],
                    isoNumeric: $row[4],
                    population: intval(value:$row[5]),
                    square: intval(value:$row[6]),
                );
                array_push($countries, $country);
            }
            // вернуть результат
            return $countries;
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($connection)) {
                $connection->close();
            }
        }
    }

    public function getByAlpha2(string $code): ?Country
    {
        try {
            // создать подключение к БД
            $connection = $this->sqlHelper->openDbConnection();
            // подготовить строку запроса
            $queryStr = '
                SELECT shortName,fullName,isoAlpha2,isoAlpha3,isoNumeric,population,square 
                FROM country_t
                WHERE isoAlpha2 = ?';
            // выполнить запрос
            $query = $connection->prepare(query: $queryStr);
            $query->bind_param('s', $code);
            // выполнить запрос
            $query->execute();
            $rows = $query->get_result();
            // считать результаты запроса в цикле 
            $countries = [];
            while ($row = $rows->fetch_array()) {
                // каждая строка считается в тип массива
                return new Country(
                    shortName: $row[0],
                    fullName: $row[1],
                    isoAlpha2: $row[2],
                    isoAlpha3: $row[3],
                    isoNumeric: $row[4],
                    population: intval(value:$row[5]),
                    square: intval(value:$row[6]),
                );
            }
            // вернуть результат
            return null;
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($connection)) {
                $connection->close();
            }
        }
    }

    public function getByAlpha3(string $code): ?Country
    {
        try {
            // создать подключение к БД
            $connection = $this->sqlHelper->openDbConnection();
            // подготовить строку запроса
            $queryStr = '
                SELECT shortName,fullName,isoAlpha2,isoAlpha3,isoNumeric,population,square 
                FROM country_t
                WHERE isoAlpha3 = ?';
            // выполнить запрос
            $query = $connection->prepare(query: $queryStr);
            $query->bind_param('s', $code);
            // выполнить запрос
            $query->execute();
            $rows = $query->get_result();
            // считать результаты запроса в цикле 
            $countries = [];
            while ($row = $rows->fetch_array()) {
                // каждая строка считается в тип массива
                return new Country(
                    shortName: $row[0],
                    fullName: $row[1],
                    isoAlpha2: $row[2],
                    isoAlpha3: $row[3],
                    isoNumeric: $row[4],
                    population: intval(value:$row[5]),
                    square: intval(value:$row[6]),
                );
            }
            // вернуть результат
            return null;
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($connection)) {
                $connection->close();
            }
        }
    }

    public function getByNumeric(string $code): ?Country
    {
        try {
            // создать подключение к БД
            $connection = $this->sqlHelper->openDbConnection();
            // подготовить строку запроса
            $queryStr = '
                SELECT shortName,fullName,isoAlpha2,isoAlpha3,isoNumeric,population,square 
                FROM country_t
                WHERE isoNumeric = ?';
            // выполнить запрос
            $query = $connection->prepare(query: $queryStr);
            $query->bind_param('s', $code);
            // выполнить запрос
            $query->execute();
            $rows = $query->get_result();
            // считать результаты запроса в цикле 
            $countries = [];
            while ($row = $rows->fetch_array()) {
                // каждая строка считается в тип массива
                return new Country(
                    shortName: $row[0],
                    fullName: $row[1],
                    isoAlpha2: $row[2],
                    isoAlpha3: $row[3],
                    isoNumeric: $row[4],
                    population: intval(value:$row[5]),
                    square: intval(value:$row[6]),
                );
            }
            // вернуть результат
            return null;
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($connection)) {
                $connection->close();
            }
        }
    }

    public function store(Country $country) : void {
        try {
            // создать подключеник к БД
            $connection = $this->sqlHelper->openDbConnection();


            // подготовить запрос INSERT
            $queryStr = '
                INSERT INTO country_t (shortName, fullName, isoAlpha2, isoAlpha3, isoNumeric, population, square)
                VALUES (?, ?, ?, ?, ?, ?, ?);';
            // подготовить запрос
            $query = $connection->prepare(query: $queryStr);
            $query->bind_param(
                'sssssid', 
                $country->shortName, 
                $country->fullName,
                 $country->isoAlpha2, 
                 $country->isoAlpha3, 
                 $country->isoNumeric,
                 $country->population,
                 $country->square,
            );
            // выполнить запрос
            if (!$query->execute()) {
                throw new Exception(message: 'query execute failed');
            }
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($connection)) {
                $connection->close();
            }
        }
    }

    public function editAlpha2(Country $country ,string $code) : void {
        try {
            // создать подключеник к БД
            $connection = $this->sqlHelper->openDbConnection();
            // подготовить запрос INSERT
            $queryStr = '
                UPDATE country_t SET 
                shortName = ?, 
                fullName = ?, 
                population = ?, 
                square = ? ,
                isoAlpha3 = ? ,
                isoNumeric = ?
                WHERE isoAlpha2 = ?';
            // подготовить запрос
            $query = $connection->prepare(query: $queryStr);
            $query->bind_param(
                'ssidsss', 
                $country->shortName, 
                $country->fullName,
                 $country->population,
                 $country->square,
                 $country->isoAlpha3, 
                 $country->isoNumeric,
                 $code
            );
            // выполнить запрос
            if (!$query->execute()) {
                throw new Exception(message: 'query execute failed');
            }
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($connection)) {
                $connection->close();
            }
        }
    }

    public function editAlpha3(Country $country ,string $code) : void {
        try {
            // создать подключеник к БД
            $connection = $this->sqlHelper->openDbConnection();
            // подготовить запрос INSERT
            $queryStr = '
                UPDATE country_t SET 
                shortName = ?, 
                fullName = ?, 
                population = ?, 
                square = ?,
                isoAlpha2 = ?,
                isoNumeric = ?
                WHERE isoAlpha3 = ?';
            // подготовить запрос
            $query = $connection->prepare(query: $queryStr);
            $query->bind_param(
                'ssidsss', 
                $country->shortName, 
                $country->fullName,
                 $country->population,
                 $country->square,
                 $country->isoAlpha2, 
                 $country->isoNumeric,
                 $code
            );
            // выполнить запрос
            if (!$query->execute()) {
                throw new Exception(message: 'query execute failed');
            }
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($connection)) {
                $connection->close();
            }
        }
    }

    public function editNumeric(Country $country ,string $code) : void {
        try {
            // создать подключеник к БД
            $connection = $this->sqlHelper->openDbConnection();
            // подготовить запрос INSERT
            $queryStr = '
                UPDATE country_t SET 
                shortName = ?, 
                fullName = ?, 
                population = ?, 
                square = ?,
                isoAlpha2 = ?,
                isoAlpha3 = ?
                WHERE isoNumeric = ?';
            // подготовить запрос
            $query = $connection->prepare(query: $queryStr);
            $query->bind_param(
                'ssidsss', 
                $country->shortName, 
                $country->fullName,
                 $country->population,
                 $country->square,
                 $country->isoAlpha2, 
                 $country->isoAlpha3, 
                 $code
            );
            // выполнить запрос
            if (!$query->execute()) {
                throw new Exception(message: 'query execute failed');
            }
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($connection)) {
                $connection->close();
            }
        }
    }

    public function deleteAlpha2(string $code) : void {
        try {
            // создать подключеник к БД
            $connection = $this->sqlHelper->openDbConnection();


            // подготовить запрос INSERT
            $queryStr = '
                DELETE FROM country_t WHERE isoAlpha2 = ?';
            // подготовить запрос
            $query = $connection->prepare(query: $queryStr);
            $query->bind_param(
                's', 
                $code
            );
            // выполнить запрос
            if (!$query->execute()) {
                throw new Exception(message: 'query execute failed');
            }
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($connection)) {
                $connection->close();
            }
        }
    }

    public function deleteAlpha3(string $code) : void {
        try {
            // создать подключеник к БД
            $connection = $this->sqlHelper->openDbConnection();


            // подготовить запрос INSERT
            $queryStr = '
                DELETE FROM country_t WHERE isoAlpha3 = ?';
            // подготовить запрос
            $query = $connection->prepare(query: $queryStr);
            $query->bind_param(
                's', 
                $code
            );
            // выполнить запрос
            if (!$query->execute()) {
                throw new Exception(message: 'query execute failed');
            }
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($connection)) {
                $connection->close();
            }
        }
    }

    public function deleteNumeric(string $code) : void {
        try {
            // создать подключеник к БД
            $connection = $this->sqlHelper->openDbConnection();


            // подготовить запрос INSERT
            $queryStr = '
                DELETE FROM country_t WHERE isoANumeric = ?';
            // подготовить запрос
            $query = $connection->prepare(query: $queryStr);
            $query->bind_param(
                's', 
                $code
            );
            // выполнить запрос
            if (!$query->execute()) {
                throw new Exception(message: 'query execute failed');
            }
        } finally {
            // в конце в любом случае закрыть соединение с БД если оно было открыто
            if (isset($connection)) {
                $connection->close();
            }
        }
    }
}