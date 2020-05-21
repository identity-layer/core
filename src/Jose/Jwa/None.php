<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwa;

use IdentityLayer\Jose\AlgorithmName;
use IdentityLayer\Jose\Exception\NoneHashingAlgorithmException;
use IdentityLayer\Jose\Jwa;
use IdentityLayer\Jose\Jwk\SigningKey;
use IdentityLayer\Jose\Jwk\VerificationKey;

/**
 * Whilst this algorithm is part of the JWA spec, it should not be used in most cases.
 */
class None implements Jwa
{
    public function name(): AlgorithmName
    {
        return AlgorithmName::NONE();
    }

    public function sign(SigningKey $key, $message): string
    {
        throw new NoneHashingAlgorithmException('Cannot sign a message using "none" algorithm.');
    }

    public function verify(VerificationKey $key, string $message, string $signature): bool
    {
        throw new NoneHashingAlgorithmException('Cannot verify a message that uses the "none" algorithm.');
    }
}