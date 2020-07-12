<?php

declare(strict_types=1);

namespace IdentityLayer\Jose;

use IdentityLayer\Jose\Jwk\SigningKey;
use IdentityLayer\Jose\Jwk\VerificationKey;

interface Jwt
{
    public static function fromCompactSerialisedFormat(VerificationKey $key, string $jwt): Jwt;
    public function toCompactSerialisedFormat(Jwa $jwa, SigningKey $key): string;
    public function getClaims(): ClaimCollection;
}
