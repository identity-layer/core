<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwk;

use IdentityLayer\Jose\AlgorithmName;
use IdentityLayer\Jose\Jwk;

interface VerificationKey extends Jwk
{
    public function verify(
        AlgorithmName $algorithmName,
        string $message,
        string $signature
    ): bool;
}