<?php

/* function generateRandomSessionString($prefix = "")
{
	$string = uniqid($prefix, true); // if prefix is empty line will be 23 characters lenght    
    return $string;
} */

function convert_encoding_to_utf8($string)
{
    $string = mb_convert_encoding($string, 'UTF-8', 'UTF-8');
    return $string;
}

