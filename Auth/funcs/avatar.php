<?php
    function getCapitals(string $full_name): string
    {
        $elements = preg_split('/\s+/', $full_name);
        // get only the first and last elements of the array, skipping the middle name
        $elements = array_slice($elements, 0, 1) + array_slice($elements, 0,2);
        $initials = array();
        foreach($elements as $element) {
          // get the first character of each element, using multibyte support
          $initials[] = mb_substr($element, 0, 1, 'UTF-8');
        }
        // join the initials with a dot
        $initials = implode('', $initials);
        return $initials;
    }
function getColor(string $name): string
{
    // level 600, see: materialuicolors.co
    $colors = [
        '#e53935', // red
        '#d81b60', // pink
        '#8e24aa', // purple
        '#5e35b1', // deep-purple
        '#3949ab', // indigo
        '#1e88e5', // blue
        '#039be5', // light-blue
        '#00acc1', // cyan
        '#00897b', // teal
        '#43a047', // green
        '#7cb342', // light-green
        '#c0ca33', // lime
        '#fdd835', // yellow
        '#ffb300', // amber
        '#fb8c00', // orange
        '#f4511e', // deep-orange
        '#6d4c41', // brown
        '#757575', // grey
        '#546e7a', // blue-grey
    ];
    $unique = hexdec(substr(md5($name), -8));
    return $colors[$unique % count($colors)];
}
?>