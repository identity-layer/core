<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwk\Hmac;

use IdentityLayer\Jose\AlgorithmName;
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

    public function toJwkFormat(): string
    {
        throw new JwkFormatNotAvailableException(
            'Cannot represent a HMAC key in JWK format. Symmetric keys are unavailable ' .
            'for representation in JWK format.'
        );
    }

    public function sign(AlgorithmName $algorithmName, string $message): string
    {
        return hash_hmac($algorithmName->hashingAlgorithm(), $message, $this->key, true);
    }

    public function verify(AlgorithmName $algorithmName, string $message, string $signature): bool
    {
        return $signature === $this->sign($algorithmName, $message);
    }
}