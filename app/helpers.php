<?php

if (! function_exists('decode_binary')) {
    function decode_binary($value): string
    {
        return collect(str_split($value, 8))
            ->map(fn ($byte) => chr(bindec($byte))) // Convert each 8-bit binary string to a character
            ->map(fn ($char) => rtrim($char)) // Remove any padding null bytes
            ->implode(''); // Combine characters into a single string
    }
}

if (! function_exists('encode_binary')) {
    function encode_binary($value): string
    {
        return collect(str_split($value))
            ->map(fn ($char) => str_pad(decbin(ord($char)), 8, '0', STR_PAD_LEFT)) // Convert each character to an 8-bit binary string
            ->implode(''); // Combine binary strings into a single string
    }
}
