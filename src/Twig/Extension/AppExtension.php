<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\AppExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('shorten', [AppExtensionRuntime::class, 'shorten']),
            new TwigFilter('currency', [AppExtensionRuntime::class, 'currency']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            // new TwigFunction('function_name', [AppExtensionRuntime::class, 'doSomething']),
        ];
    }
}
