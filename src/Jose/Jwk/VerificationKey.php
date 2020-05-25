<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwk;

use IdentityLayer\Jose\JwaEnum;
use IdentityLayer\Jose\Jwk;

interface VerificationKey extends Jwk
{
    public function verify(
        JwaEnum $algorithmName,
        string $message,
        string $signature
    ): bool;
}