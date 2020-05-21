<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwk\Hmac;

use IdentityLayer\Jose\AlgorithmFamily;
use IdentityLayer\Jose\AlgorithmName;
use IdentityLayer\Jose\Exception\InvalidAlgorithmException;
use IdentityLayer\Jose\Exception\JwkFormatNotAvailableException;
use IdentityLayer\Jose\Jwk\SigningKey;
use IdentityLayer\Jose\Jwk\VerificationKey;

abstract class HmacKeyAbstract implements SigningKey, VerificationKey
{
    protected string $kid;
    protected string $key;

    protected function __construct(string $kid, string $key)
    {
        $this->kid = $kid;
        $this->key = $key;
    }

    public static function fromKidAndKey(string $kid, string $key): HmacKeyAbstract
    {
        return new static($kid, $key);
    }

    public function kid(): string
    {
        return $this->kid;
    }

    public function sign(AlgorithmName $algorithmName, string $message): string
    {
        if (!$algorithmName->algorithmFamily()->equals(AlgorithmFamily::HS())) {
            throw new InvalidAlgorithmException(
                sprintf(
                    sprintf(
                        '%s is not a valid HMAC algorithm for use with this key',
                        $algorithmName->getValue()
                    ),
                )
            );
        }

        return hash_hmac($algorithmName->hashingAlgorithm(), $message, $this->key, true);
    }

    public function verify(AlgorithmName $algorithmName, string $message, string $signature): bool
    {
        if (!$algorithmName->algorithmFamily()->equals(AlgorithmFamily::HS())) {
            throw new InvalidAlgorithmException(
                sprintf(
                    sprintf(
                        '%s is not a valid HMAC algorithm for use with this key',
                        $algorithmName->getValue()
                    ),
                )
            );
        }

        return $signature === $this->sign($algorithmName, $message);
    }
}