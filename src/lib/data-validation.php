<?php

/**
 * Validates the product data.
 *
 * @param string $name The product name.
 * @param string $description The product description.
 * @param int $min_servings The minimum servings.
 * @param float $price The product price.
 * @param string $type The dish type.
 * @param array|null $image The image file.
 * @return void|string Returns void if the product data is valid, otherwise returns an error message.
 */
function isInvalidProductData(string $name, string $description, int $min_servings, float $price, string $type, ?array $image = null)
{
    if (!isValidString($name)) {
        return "Invalid product name. Please enter a valid product name.";
    }

    if (!isset($description)) {
        return "Invalid product name. Please enter a valid product name.";
    }

    if (!isValidInteger($min_servings)) {
        return "Invalid minimum servings. Please enter a valid minimum amount.";
    }

    if (!isValidFloat($price)) {
        return "Invalid price, enter a valid amount.";
    }

    if (!isValidString($type) || !in_array($type, DISHES_TYPES)) {
        return "Invalid dish type. Please enter a valid dish type.";
    }

    if (isset($image) && !isValidImage($image)) {
        return "Invalid image file. Please upload a valid image file.";
    }
}
