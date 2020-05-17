<?php

declare(strict_types=1);

namespace IdentityLayer\Core\Jose\Claim;

use IdentityLayer\Core\Jose\Claim;

class BooleanClaim implements Claim
{
    private string $key;
    private bool $value;

    private function __construct(string $key, bool $value)
    {
        $this->key = $key;
        $this->value = $value;
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