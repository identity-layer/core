<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Claim;

use IdentityLayer\Jose\Claim;

class BooleanClaim implements Claim
{
    private string $key;
    private bool $value;

    private function __construct(string $key, bool $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @param string $key
     * @param bool $value
     * @return Claim
     */
    public static function fromKeyValue(string $key, $value): Claim
    {
        return new BooleanClaim($key, $value);
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function jsonSerialize(): array
    {
        return [
            $this->key => $this->value
        ];
    }
}
