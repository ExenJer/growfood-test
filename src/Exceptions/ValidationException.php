<?php


namespace Exrs\Pricer\Exceptions;


use Throwable;

class ValidationException extends \Exception
{
    /**
     * ValidationException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "Invalid input data", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}