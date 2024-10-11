<?php

namespace App\Model\Exceptions;

use Throwable;
use Exception;

class InvalidValueException extends Exception {

    // переопределение конструктора исключения
    public function __construct($invalidValue, $message, Throwable $previous = null) {
        $exceptionMessage = "airport code '". $invalidValue ."' is invalid: ".$message;
        // вызов конструктора базового класса исключения
        parent::__construct(
            message: $exceptionMessage, 
            code: ErrorCodes::INVALID_CODE_ERROR,
            previous: $previous,
        );
    }
}