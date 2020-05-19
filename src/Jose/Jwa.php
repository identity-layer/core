<?php

declare(strict_types=1);

namespace IdentityLayer\Jose;

use IdentityLayer\Jose\Jwk\SigningKey;
use IdentityLayer\Jose\Jwk\VerificationKey;

interface Jwa
{
    public function name(): AlgorithmName;

    public function sign(SigningKey $key, $message): string;

    public function verify(VerificationKey $key, string $message, string $signature): bool;
}