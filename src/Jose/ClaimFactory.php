<?php

declare(strict_types=1);

namespace IdentityLayer\Jose;

use AlvinChevolleaux\Collection\Collection;
use IdentityLayer\Jose\Claim\BooleanClaim;
use IdentityLayer\Jose\Claim\EmailClaim;
use IdentityLayer\Jose\Claim\GenericClaim;
use IdentityLayer\Jose\Claim\LocaleClaim;
use IdentityLayer\Jose\Claim\PhoneNumberClaim;
use IdentityLayer\Jose\Claim\TimestampClaim;
use IdentityLayer\Jose\Claim\UrlClaim;
use IdentityLayer\Jose\Claim\ZoneInfoClaim;

class ClaimFactory
{
    public static function createClaims(array $claims): ClaimCollection
    {
        $parsedClaims = [];

        foreach ($claims as $key => $value) {
            $parsedClaims[] = static::createClaim($key, $value);
        }

        /** @var ClaimCollection $collection */
        $collection = ClaimCollection::fromArray($parsedClaims);

        return $collection;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return Claim
     */
    public static function createClaim(string $key, $value): Claim
    {
        $claim = static::getClaim($key, $value);

        if (RegisteredClaimEnum::search($key)) {
            return new RegisteredClaim(new RegisteredClaimEnum($key), $claim);
        }

        return $claim;
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return Claim
     */
    private static function getClaim($key, $value): Claim
    {
        switch ($key) {
            case RegisteredClaimEnum::PROFILE:
            case RegisteredClaimEnum::PICTURE:
            case RegisteredClaimEnum::WEBSITE:
                return UrlClaim::fromKeyValue($key, $value);
            case RegisteredClaimEnum::EMAIL:
                return EmailClaim::fromKeyValue($key, $value);
            case RegisteredClaimEnum::ISSUED_AT:
            case RegisteredClaimEnum::NOT_BEFORE:
            case RegisteredClaimEnum::EXPIRATION_TIME:
            case RegisteredClaimEnum::AUTH_TIME:
                return TimestampClaim::fromKeyValue($key, $value);
            case RegisteredClaimEnum::EMAIL_VERIFIED:
            case RegisteredClaimEnum::PHONE_NUMBER_VERIFIED:
                return BooleanClaim::fromKeyValue($key, $value);
            case RegisteredClaimEnum::LOCALE:
                return LocaleClaim::fromKeyValue($key, $value);
            case RegisteredClaimEnum::PHONE_NUMBER:
                return PhoneNumberClaim::fromKeyValue($key, $value);
            case RegisteredClaimEnum::ZONE_INFO:
                return ZoneInfoClaim::fromKeyValue($key, $value);
            default:
                return GenericClaim::fromKeyValue($key, $value);
        }
    }
}
