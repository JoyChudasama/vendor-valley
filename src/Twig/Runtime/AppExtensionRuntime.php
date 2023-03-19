<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class AppExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function shorten(string $string, int $maxChars)
    {
        return strlen($string) > $maxChars ? substr($string, 0, $maxChars) . '...' : $string;
    }
}
