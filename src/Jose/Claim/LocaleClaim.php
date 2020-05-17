<?php

declare(strict_types=1);

namespace IdentityLayer\Core\Jose\Claim;

use IdentityLayer\Core\Jose\Claim;
use InvalidArgumentException;

class LocaleClaim implements Claim
{
    private string $key;
    private string $value;

    private function __construct(string $key, string $locale)
    {
        if (!preg_match('/^[a-z]{2}[_-][A-Z]{2}$/', $locale)) {
            throw new InvalidArgumentException('%s is not a valid locale');
        }

        $this->key = $key;
        $this->value = str_replace('_', '-', $locale);
    }

    public static function fromKeyValue(string $key, $value): Claim
    {
        return new static($key, $value);
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function jsonSerialize()
    {
        return [
            $this->key => $this->value
        ];
    }
}