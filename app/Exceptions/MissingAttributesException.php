<?php

namespace App\Exceptions;

use Exception;

class MissingAttributesException extends Exception
{
    /**
     * Create a missing attributes exception.
     *
     * @param  array<int, string>  $missingAttributes  Missing attribute names.
     * @return void
     */
    public function __construct(array $missingAttributes)
    {
        parent::__construct('Missing attributes: '.implode(', ', $missingAttributes));
    }
}
