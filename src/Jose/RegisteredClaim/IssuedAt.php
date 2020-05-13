<?php

declare(strict_types=1);

namespace IdentityLayer\Core\Jose\RegisteredClaim;

use IdentityLayer\Core\Jose\RegisteredClaimEnum;

class IssuedAt
{
    use TimestampClaimTrait;

    public static function fromTimestamp(int $timestamp): ExpirationTime
    {
        return new ExpirationTime(RegisteredClaimEnum::ISSUED_AT(), $timestamp);
    }
}