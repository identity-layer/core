<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwa;

use IdentityLayer\Jose\JwaEnum;
use IdentityLayer\Jose\Jwk\SigningKey;
use IdentityLayer\Jose\Jwk\VerificationKey;

trait JwaTrait
{
    public function name(): JwaEnum
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