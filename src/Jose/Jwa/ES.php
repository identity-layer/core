<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwa;

use IdentityLayer\Jose\AlgorithmName;
use IdentityLayer\Jose\Exception\NotImplementedException;
use IdentityLayer\Jose\Jwa;
use IdentityLayer\Jose\Jwk\SigningKey;
use IdentityLayer\Jose\Jwk\VerificationKey;

class ES implements Jwa
{
    public function __construct()
    {
        throw new NotImplementedException('This algorithm has not been implemented. This ' .
            'library is still in an experimental state and should be used with caution in any ' .
            'production environment');
    }

    public function name(): AlgorithmName
    {
        // TODO: Implement name() method.
    }

    public function sign(SigningKey $key, $message): string
    {
        // TODO: Implement sign() method.
    }

    public function verify(VerificationKey $key, string $message, string $signature): bool
    {
        // TODO: Implement verify() method.
    }
}