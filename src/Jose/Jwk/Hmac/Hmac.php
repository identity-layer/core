<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwk\Hmac;

use IdentityLayer\Jose\JwaFamilyEnum;
use IdentityLayer\Jose\JwaEnum;
use IdentityLayer\Jose\Exception\InvalidAlgorithmException;
use IdentityLayer\Jose\Exception\InvalidArgumentException;
use IdentityLayer\Jose\Jwk\SigningKey;
use IdentityLayer\Jose\Jwk\VerificationKey;

final class Hmac implements SigningKey, VerificationKey
{
    private string $kid;
    private string $key;

    private function __construct(string $kid, string $key)
    {
        if (strlen($key) < 32) {
            throw new InvalidArgumentException('HMAC key must be at least 256bits');
        }

        $this->kid = $kid;
        $this->key = $key;
    }

    public static function fromKidAndKey(string $kid, string $key): Hmac
    {
        return new static($kid, $key);
    }

    public function kid(): string
    {
        return $this->kid;
    }

    public function sign(JwaEnum $algorithm, string $message): string
    {
        $this->validateAlgorithm($algorithm);

        return hash_hmac($algorithm->hashingAlgorithm(), $message, $this->key, true);;
    }

    public function verify(JwaEnum $algorithm, string $message, string $signature): bool
    {
        return $this->verify($algorithm, $message, $signature);
    }

    private function validateAlgorithm(JwaEnum $algorithm): void
    {
        if (!$algorithm->family()->equals(JwaFamilyEnum::HS())) {
            throw new InvalidAlgorithmException(
                sprintf(
                    '%s is not a valid HMAC algorithm for use with this key',
                    $algorithm->getValue()
                )
            );
        }

        $keyLength = strlen($this->key);

        if (strlen($this->key) < $algorithm->hmacRequiredKeyLength()) {
            throw new InvalidAlgorithmException(
                sprintf(
                    '%s algorithm is not compatible with HMAC key of length %s',
                    $algorithm->getValue(),
                    $keyLength
                )
            );
        }
    }
}