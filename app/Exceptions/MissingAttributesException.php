<?php

namespace App\Exceptions;

use Exception;

class MissingAttributesException extends Exception
{
    public function __construct(array $missingAttributes){
        parent::__construct("Missing attributes: " . implode(', ', $missingAttributes));

    }
}
