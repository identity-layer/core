<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Claim;

use IdentityLayer\Jose\Claim;
use IdentityLayer\Jose\Exception\InvalidArgumentException;

class PhoneNumberClaim implements Claim
{
    private string $key;
    private string $value;

    private function __construct(string $key, string $phoneNumber)
    {
        if (!preg_match('/^\+[1-9]\d{1,14}$/', str_replace(' ', '', $phoneNumber))) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid phone number: %s. Expecting E.164 format phone number',
                    $phoneNumber
                )
            );
        }

        $this->key = $key;
        $this->value = $phoneNumber;
    }

    /**
     * @param string $key
     * @param string $value
     * @return Claim
     */
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