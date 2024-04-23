<?php

declare(strict_types=1);

namespace App;

use Exception;

class ServerErrorLog
{
    /**
     * Logs an error message to the server error log.
     *
     * @param Exception $error The error message to log.
     * @return void
     */
    static public function logError(Exception $error): void
    {
        error_log($error->getMessage() . ' ' . $error->getCode() . ' ' . $error->getTraceAsString() . ' ' . $error->getFile() . ' ' . $error->getLine() . ' ' . $error->getPrevious() . ' ' . $error->getTrace());
    }
}
