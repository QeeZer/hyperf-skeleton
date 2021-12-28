<?php

namespace App\Exception;

use Exception;
use QeeZer\HyperfApiResponder\Contracts\NondisclosureException;

class SystemException extends Exception implements NondisclosureException
{
    public function __construct(Exception $exception)
    {
        parent::__construct($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
    }
}