<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Claim;

use IdentityLayer\Jose\Claim;
use InvalidArgumentException;

class EmailClaim implements Claim
{
    private string $key;
    private string $value;

    private function __construct(string $key, string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException(
                sprintf('%s is not a valid email address', $email)
            );
        }

        $this->key = $key;
        $this->value = $email;
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