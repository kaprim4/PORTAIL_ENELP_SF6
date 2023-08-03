<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\TwigTest;

final class TypeExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('phone', [$this, 'phoneFilter']),
            new TwigFilter('pluralize', [$this, 'pluralize']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_env', [$this, 'getEnvironmentVariable']),
            new TwigFunction('get_php_version', [$this, 'getPhpVersion']),
        ];
    }

    public function getTests(): array
    {
        return [
            'of_type' => new TwigTest('of_type', [$this, 'ofType']),
        ];
    }

    public function ofType(mixed $var, string $test, string $class = null): bool
    {
        return match ($test) {
            'array' => is_array($var),
            'bool' => is_bool($var),
            'object' => is_object($var),
            'class' => is_object($var) && $class === get_class($var),
            'float' => is_float($var),
            'int' => is_int($var),
            'numeric' => is_numeric($var),
            'scalar' => is_scalar($var),
            'string' => is_string($var),
            default => throw new \InvalidArgumentException(sprintf('Invalid "%s" type test.', $test)),
        };
    }

    public function phoneFilter($phoneNumber): array|string|null
    {
        if (str_starts_with($phoneNumber, "+212")) {
            return preg_replace("/(\+212)(\d{3})(\d{2})(\d{2})(\d{2})/", "$1 ($2)-$3 $4 $5", $phoneNumber);
        }
        return preg_replace("/(\d{4})(\d{2})(\d{2})(\d{2})/", "($1)-$2 $3 $4", $phoneNumber);
    }

    public function pluralize(int $count, string $word): string
    {
        $formatedWord = $word;
        $voyelles = ['a', 'e', 'u', 'i', 'o', 'h'];
        $has_voyelle = false;
        foreach ($voyelles as $voyelle) {
            if (str_starts_with($formatedWord, $voyelle))
                $has_voyelle = true;
        }
        if ($count == 0) {
            return 'Pas ' . ($has_voyelle ? "d'" : "de ") . $formatedWord;
        } else {
            if ($count > 1) {
                $formatedWord .= 's';
            }
        }
        return $count . ' ' . $formatedWord;
    }

    /**
     * Return the value of the requested environment variable.
     *
     * @param String $varname
     * @return String
     */
    public function getEnvironmentVariable(string $varname): string
    {
        return $_ENV[$varname];
    }

    public function getPhpVersion(): string
    {
        return PHP_VERSION;
    }
}