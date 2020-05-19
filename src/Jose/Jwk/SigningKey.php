<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwk;

use IdentityLayer\Jose\AlgorithmName;
use IdentityLayer\Jose\Jwk;

interface SigningKey extends Jwk
{
    public function sign(AlgorithmName $algorithmName, string $message): string;
}