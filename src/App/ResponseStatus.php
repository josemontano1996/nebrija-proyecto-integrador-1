<?php

declare(strict_types=1);

namespace App;

class ResponseStatus
{
    /**
     * Sends an error status response and stop script execution.
     *
     * @param int $status_code The HTTP status code to send.
     * @param string|null $message The message to send. Default is null.
     * @param string|null $redirect_url The URL to redirect to after sending the response. Default is null.
     * @param bool|null $is_ajax_response Indicates if the response is an AJAX response. Default is false.
     * @return void
     */
    static public function sendResponseStatus(int $status_code, ?string $message = null, ?string $redirect_url = null, ?bool $is_ajax_response = false): void
    {
        if ($is_ajax_response) {
            // Set the response code
            http_response_code($status_code);
            //Set the response content type
            if ($redirect_url) {
                //This one redirect the user to the URL
                echo json_encode($redirect_url);
            } else {

                echo json_encode($message);
            }
        } else {
            // Set the session message
            if ($message) {
                $status_code === 200 ? $_SESSION['success'] = $message : $_SESSION['error'] = $message;
            }
            // Set the response code
            http_response_code($status_code);
            // Redirect if needed
            if ($redirect_url) {
                header('Location: ' . $redirect_url);
            }
        }

        exit();
    }
}
