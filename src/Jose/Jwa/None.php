<?php

declare(strict_types=1);

namespace IdentityLayer\Core\Jose\Jwa;

use IdentityLayer\Core\Jose\AlgorithmFamily;
use IdentityLayer\Core\Jose\AlgorithmName;
use IdentityLayer\Core\Jose\Exception\NoneAlgorithmIllegalOperationException;
use IdentityLayer\Core\Jose\Jwa;

class None implements Jwa
{
    public function name(): AlgorithmName
    {
        return AlgorithmName::NONE();
    }

    public function type(): AlgorithmFamily
    {
        AlgorithmFamily::NONE();
    }

    public function sign($message): string
    {
        return '';
    }

    public function verify(string $message, string $signature): bool
    {
        return strlen($signature) === 0;
    }

    public function toPublicJwkFormat(): array
    {
        throw new NoneAlgorithmIllegalOperationException('Cannot output none JWA to Jwk format.');
    }

    public function kid(): string
    {
        throw new NoneAlgorithmIllegalOperationException('None algorithm has no ID.');
    }
}