<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Claim;

use IdentityLayer\Jose\Claim;
use InvalidArgumentException;

class GenericClaim implements Claim
{
    private string $key;
    private $value;

    private function __construct(string $key, $value)
    {
        $jsonEncoded = json_encode($value);

        if ($jsonEncoded === false || json_decode($jsonEncoded, true) !== $value) {
            throw new InvalidArgumentException(
                sprintf('%s is not a valid JSON serialisable claim', $value)
            );
        }

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