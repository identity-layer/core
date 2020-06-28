<?php

declare(strict_types=1);

namespace IdentityLayer\Jose;

use MyCLabs\Enum\Enum;

/**
 * Enumerator listing registered claims from https://www.iana.org.
 *
 * Class RegisteredClaimEnum
 * @package IdentityLayer\Core\Jose
 *
 * @method static RegisteredClaimEnum ISSUER()
 * @method static RegisteredClaimEnum SUBJECT()
 * @method static RegisteredClaimEnum AUDIENCE()
 * @method static RegisteredClaimEnum EXPIRATION_TIME()
 * @method static RegisteredClaimEnum NOT_BEFORE()
 * @method static RegisteredClaimEnum ISSUED_AT()
 * @method static RegisteredClaimEnum JWT_ID()
 * @method static RegisteredClaimEnum NAME()
 * @method static RegisteredClaimEnum GIVEN_NAME()
 * @method static RegisteredClaimEnum FAMILY_NAME()
 * @method static RegisteredClaimEnum MIDDLE_NAME()
 * @method static RegisteredClaimEnum NICKNAME()
 * @method static RegisteredClaimEnum PROFILE()
 * @method static RegisteredClaimEnum PICTURE()
 * @method static RegisteredClaimEnum WEBSITE()
 * @method static RegisteredClaimEnum EMAIL()
 * @method static RegisteredClaimEnum EMAIL_VERIFIED()
 * @method static RegisteredClaimEnum BIRTH_DATE()
 * @method static RegisteredClaimEnum ZONE_INFO()
 * @method static RegisteredClaimEnum LOCALE()
 * @method static RegisteredClaimEnum PHONE_NUMBER()
 * @method static RegisteredClaimEnum PHONE_NUMBER_VERIFIED()
 * @method static RegisteredClaimEnum UPDATED_AT()
 * @method static RegisteredClaimEnum AUTH_TIME()
 */
class RegisteredClaimEnum extends Enum
{
    public const ISSUER = 'iss';
    public const SUBJECT = 'sub';
    public const AUDIENCE = 'aud';
    public const EXPIRATION_TIME = 'exp';
    public const NOT_BEFORE = 'nbf';
    public const ISSUED_AT = 'iat';
    public const JWT_ID = 'jti';
    public const NAME = 'name';
    public const GIVEN_NAME = 'given_name';
    public const FAMILY_NAME = 'family_name';
    public const MIDDLE_NAME = 'middle_name';
    public const NICKNAME = 'nickname';
    public const PROFILE = 'profile';
    public const PICTURE = 'picture';
    public const WEBSITE = 'website';
    public const EMAIL = 'email';
    public const EMAIL_VERIFIED = 'email_verified';
    public const BIRTH_DATE = 'birthdate';
    public const ZONE_INFO = 'zoneinfo';
    public const LOCALE = 'locale';
    public const PHONE_NUMBER = 'phone_number';
    public const PHONE_NUMBER_VERIFIED = 'phone_number_verified';
    public const UPDATED_AT = 'updated_at';
    public const AUTH_TIME = 'auth_time';
}
