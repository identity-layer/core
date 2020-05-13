<?php

declare(strict_types=1);

namespace IdentityLayer\Core\Jose;

use MyCLabs\Enum\Enum;

/**
 * Enumerator listing registered claims from https://www.iana.org.
 *
 * Class RegisteredClaimEnum
 * @package IdentityLayer\Core\Jose
 *
 * @method static RegisteredClaimEnum ISSUER
 * @method static RegisteredClaimEnum SUBJECT
 * @method static RegisteredClaimEnum AUDIENCE
 * @method static RegisteredClaimEnum EXPIRATION_TIME
 * @method static RegisteredClaimEnum NOT_BEFORE
 * @method static RegisteredClaimEnum ISSUED_AT
 * @method static RegisteredClaimEnum JWT_ID
 * @method static RegisteredClaimEnum NAME
 * @method static RegisteredClaimEnum GIVEN_NAME
 * @method static RegisteredClaimEnum FAMILY_NAME
 * @method static RegisteredClaimEnum MIDDLE_NAME
 * @method static RegisteredClaimEnum NICKNAME
 * @method static RegisteredClaimEnum PROFILE
 * @method static RegisteredClaimEnum PICTURE
 * @method static RegisteredClaimEnum WEBSITE
 * @method static RegisteredClaimEnum EMAIL
 * @method static RegisteredClaimEnum EMAIL_VERIFIED
 * @method static RegisteredClaimEnum BIRTH_DATE
 * @method static RegisteredClaimEnum ZONE_INFO
 * @method static RegisteredClaimEnum LOCALE
 * @method static RegisteredClaimEnum PHONE_NUMBER
 * @method static RegisteredClaimEnum PHONE_NUMBER_VERIFIED
 * @method static RegisteredClaimEnum UPDATED_AT
 * @method static RegisteredClaimEnum AUTH_TIME
 */
class RegisteredClaimEnum extends Enum
{
    private const ISSUER = 'iss';
    private const SUBJECT = 'sub';
    private const AUDIENCE = 'aud';
    private const EXPIRATION_TIME = 'exp';
    private const NOT_BEFORE = 'nbf';
    private const ISSUED_AT = 'iat';
    private const JWT_ID = 'jti';
    private const NAME = 'name';
    private const GIVEN_NAME = 'given_name';
    private const FAMILY_NAME = 'family_name';
    private const MIDDLE_NAME = 'middle_name';
    private const NICKNAME = 'nickname';
    private const PROFILE = 'profile';
    private const PICTURE = 'picture';
    private const WEBSITE = 'website';
    private const EMAIL = 'email';
    private const EMAIL_VERIFIED = 'email_verified';
    private const BIRTH_DATE = 'birthdate';
    private const ZONE_INFO = 'zoneinfo';
    private const LOCALE = 'locale';
    private const PHONE_NUMBER = 'phone_number';
    private const PHONE_NUMBER_VERIFIED = 'phone_number_verified';
    private const UPDATED_AT = 'updated_at';
    private const AUTH_TIME = 'auth_time';
}