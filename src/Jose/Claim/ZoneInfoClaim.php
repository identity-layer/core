<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Claim;

use DateTimeZone;
use Exception;
use IdentityLayer\Jose\Claim;
use IdentityLayer\Jose\Exception\InvalidArgumentException;

class ZoneInfoClaim implements Claim
{
    private string $key;
    private string $value;

    private function __construct(string $key, string $timezone)
    {
        try {
            new DateTimeZone($timezone);
        } catch (Exception $e) {
            throw new InvalidArgumentException(sprintf('%s is not a valid timezone', $timezone));
        }

        $this->key = $key;
        $this->value = $timezone;
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