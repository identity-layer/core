<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Claim;

use DateTimeImmutable;
use Exception;
use IdentityLayer\Jose\Claim;
use InvalidArgumentException;

class TimestampClaim implements Claim
{
    private string $key;
    private DateTimeImmutable $value;

    private function __construct(string $key, int $timestamp)
    {
        try {
            $dateTime = DateTimeImmutable::createFromFormat('U', (string) $timestamp);
        } catch (Exception $e) {
            throw new InvalidArgumentException(
                sprintf('Invalid timestamp %d', $timestamp)
            );
        }
        $this->key = $key;
        $this->value = $dateTime;
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
        return $this->value->getTimestamp();
    }

    public function jsonSerialize()
    {
        return [
            $this->key => $this->value->getTimestamp()
        ];
    }
}