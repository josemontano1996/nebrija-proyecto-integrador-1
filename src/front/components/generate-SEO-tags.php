<?php

declare(strict_types=1);
function generateSEOTags(?string $title = null, ?string $description = null)
{
    if (!isset($title)) {
        $title = 'Chef Manuelle Webpage';
    }

    if (!isset($description)) {
        $description = 'Chef Manuelle is a culinary virtuoso with over 25 years of culinary expertise. Her journey in the world of gastronomy has been nothing short of extraordinary. Having honed her skills in the most prestigious kitchens around the globe, she now stands at the threshold of a new culinary adventure.';
    }


    $metaDescription = '<meta name="description" content="' . $description . '">';
    return <<<HTML
     <title>$title</title>
    $metaDescription
HTML;
}
