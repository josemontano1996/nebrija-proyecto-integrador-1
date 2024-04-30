<?php

declare(strict_types=1);

/**
 * Checks if a string is valid based on the given minimum length.
 *
 * @param string $string The string to validate.
 * @param int|null $minLength The minimum length required for the string (default: 0).
 * @return bool Returns true if the string is valid, false otherwise.
 */
function isValidString(string $string, ?int $minLength = 1): bool
{
    return strlen($string) >= $minLength;
}

/**
 * Checks if an email address is valid.
 *
 * @param string $email The email address to validate.
 * @return bool Returns true if the email address is valid, false otherwise.
 */
function isValidEmail(string $email): bool
{
    return isset($email) && filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Checks if an image file is valid.
 *
 * @param array $file The file array containing information about the image.
 * @return bool Returns true if the image file is valid, false otherwise.
 */
function isValidImage(array $file): bool
{
    $supportedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];

    return isset($file) && $file['error'] === 0 && in_array($file['type'], $supportedTypes);
}

/**
 * Checks if an integer is valid.
 *
 * @param int $integer The integer to validate.
 * @param int|null $minValue The minimum value the integer can have (optional, default is 0).
 * @return bool Returns true if the integer is valid, false otherwise.
 */
function isValidInteger(int $integer, ?int $minValue = 0): bool
{
    return isset($integer) && $integer >= $minValue;
}

/**
 * Checks if a float is valid.
 *
 * @param float $float The float to validate.
 * @param float|null $minValue The minimum value the float can have (optional, default is 0.0).
 * @return bool Returns true if the float is valid, false otherwise.
 */
function isValidFloat(float $float, ?float $minValue = 0.0): bool
{
    return isset($float) && filter_var($float, FILTER_VALIDATE_FLOAT) && ($float >= $minValue);
}
