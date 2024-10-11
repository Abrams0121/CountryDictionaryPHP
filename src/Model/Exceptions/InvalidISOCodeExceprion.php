<?php

namespace App\Model\Exceptions;

use Throwable;
use Exception;

class InvalidISOCodeException extends Exception {

    // переопределение конструктора исключения
    public function __construct($invalidCode, $message, Throwable $previous = null) {
        $exceptionMessage = "airport code '". $invalidCode ."' is invalid: ".$message;
        // вызов конструктора базового класса исключения
        parent::__construct(
            message: $exceptionMessage, 
            code: ErrorCodes::INVALID_VALUE_ERROR,
            previous: $previous,
        );
    }
}