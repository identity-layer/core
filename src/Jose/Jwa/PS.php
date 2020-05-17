<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwa;

use IdentityLayer\Jose\AlgorithmFamily;
use IdentityLayer\Jose\AlgorithmName;
use IdentityLayer\Jose\Jwa;

class PS implements Jwa
{
    public function name(): AlgorithmName
    {
        // TODO: Implement name() method.
    }

    public function type(): AlgorithmFamily
    {
        // TODO: Implement type() method.
    }

    public function sign($message): string
    {
        // TODO: Implement sign() method.
    }

    public function verify(string $message, string $signature): bool
    {
        // TODO: Implement verify() method.
    }

    public function toPublicJwkFormat(): array
    {
        // TODO: Implement toPublicJwkFormat() method.
    }

    public function kid(): string
    {
        // TODO: Implement kid() method.
    }
}