<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwk;

interface KeyPair extends SigningKey, VerificationKey
{
    public function getVerificationKey(): VerificationKey;
}