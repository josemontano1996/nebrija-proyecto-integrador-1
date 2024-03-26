<?php

declare(strict_types=1);

/**
 * Validates the product data.
 *
 * @param string $name The product name.
 * @param string $description The product description.
 * @param int $min_servings The minimum servings.
 * @param float $price The product price.
 * @param string $type The dish type.
 * @param array|null $image The image file.
 * @return string Returns empty string if the product data is valid, otherwise returns an error message.
 */
function isInvalidProductData(string $name, string $description, int $min_servings, float $price, string $type, ?array $image = null): string
{
    $error = '';

    if (!isValidString($name)) {
        $error = $error . "</br>" . "Invalid product name. Please enter a valid product name.";
    }

    if (!isset($description)) {
        $error = $error . "</br>" . "Invalid product name. Please enter a valid product name.";
    }

    if (!isValidInteger($min_servings)) {
        $error = $error . "</br>" . "Invalid minimum servings. Please enter a valid minimum amount.";
    }

    if (!isValidFloat($price)) {
        $error = $error . "</br>" . "Invalid price, enter a valid amount.";
    }

    if (!isValidString($type) || !in_array($type, DISHES_TYPES)) {
        $error = $error . "</br>" . "Invalid dish type. Please enter a valid dish type.";
    }

    if (isset($image) && !isValidImage($image)) {
        $error = $error . "</br>" . "Invalid image file. Please upload a valid image file.";
    }

    return $error;
}

function isInvalidDeliveryData(string $user_name, string $street, string $postal, string $city, string $deliveryDate): string
{
    $error = '';

    if (!isset($user_name)) {
        $error = $error . "</br>" . "User name field is mandatory.";
    }
    if (!isset($street)) {
        $error = $error . "</br>" . "Street field is mandatory.";
    }

    if (!isset($postal)) {
        $error = $error . "</br>" . "Postal field is mandatory.";
    }

    if (!isset($city)) {
        $error = $error . "</br>" . "City field is mandatory.";
    }
    if (!isset($deliveryDate)) {
        $error = $error . "</br>" . "Delivery date field is mandatory.";
    }

    return $error;
}
