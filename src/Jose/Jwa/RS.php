<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwa;

use IdentityLayer\Jose\AlgorithmFamily;
use IdentityLayer\Jose\AlgorithmName;
use IdentityLayer\Jose\Jwa;
use IdentityLayer\Jose\Jwk\SigningKey;
use IdentityLayer\Jose\Jwk\VerificationKey;

class RS implements Jwa
{
    private AlgorithmName $algorithm;

    public function __construct(AlgorithmName $algorithm)
    {
        $this->algorithm = $algorithm;
    }

    public function type(): AlgorithmFamily
    {
        return AlgorithmFamily::RS();
    }

    public function name(): AlgorithmName
    {
        return $this->algorithm;
    }

    public function sign(SigningKey $key, $message): string
    {
        return $key->sign($this->algorithm, $message);
    }

    public function verify(VerificationKey $key, string $message, string $signature): bool
    {
        return $key->verify($this->algorithm, $message, $signature);
    }
}