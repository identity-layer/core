<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwk;

interface JwkSerialisable
{
    public function toJwkFormat(): array;
}
