<?php

declare(strict_types=1);

namespace IdentityLayer\Jose;

use IdentityLayer\Jose\Jwk\SigningKey;

interface Jwt
{
    public static function toCompactSerialisedFormat(
        SigningKey $key,
        Jwa $jwa,
        ClaimCollection $claims,
        array $header = null
    ): string;
}
