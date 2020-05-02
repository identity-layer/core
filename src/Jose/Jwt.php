<?php

declare(strict_types=1);

namespace IdentityLayer\Core\Jose;

interface Jwt
{
    public static function toCompactSerialisedFormat(Jwa $jwa, array $claims, array $header = null): string;
}