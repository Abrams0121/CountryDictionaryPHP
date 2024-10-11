<?php

namespace App\Model\Exceptions;

use Throwable;
use Exception;

// DuplicatedCodeException - исключение дублирующегося кода аэропорта
class CodeCollisionException extends Exception {

    // переопределение конструктора исключения
    public function __construct(Throwable $previous = null) {
        $exceptionMessage = "country code of edited line and new line are not the same";
        // вызов конструктора базового класса исключения
        parent::__construct(
            message: $exceptionMessage, 
            code: ErrorCodes::CODE_COLLISION_ERROR,
            previous: $previous,
        );
    }
}