<?php

namespace App\Exceptions;

class ErrorDbException extends \Exception
{
    protected $message = 'Error connecting to the database';
}
