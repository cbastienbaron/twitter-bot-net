<?php

namespace App\Bot\Exception;


use Throwable;

class RateLimitException extends \Exception
{
    /** @var string $type the type of API */
    private $type;

    /** @var  string $name  */
    private $name;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
