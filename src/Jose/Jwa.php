<?php

declare(strict_types=1);

namespace IdentityLayer\Core\Jose;

interface Jwa
{
    public function name(): AlgorithmName;

    public function type(): AlgorithmFamily;

    public function sign($message): string;

    public function verify(string $message, string $signature): bool;

    public function toPublicJwkFormat(): array;

    public function kid(): string;
}