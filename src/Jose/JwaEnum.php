<?php

declare(strict_types=1);

namespace IdentityLayer\Jose;

use IdentityLayer\Jose\Exception\InvalidAlgorithmException;
use IdentityLayer\Jose\Exception\NoneAlgorithmException;
use IdentityLayer\Jose\Exception\UnrecognisedJwaException;
use MyCLabs\Enum\Enum;

/**
 * Class AlgorithmName
 * @package IdentityLayer\Core\Jose
 * @method static JwaEnum HS256()
 * @method static JwaEnum HS384()
 * @method static JwaEnum HS512()
 * @method static JwaEnum RS256()
 * @method static JwaEnum RS384()
 * @method static JwaEnum RS512()
 * @method static JwaEnum ES256()
 * @method static JwaEnum ES384()
 * @method static JwaEnum ES512()
 * @method static JwaEnum PS256()
 * @method static JwaEnum PS384()
 * @method static JwaEnum PS512()
 * @method static JwaEnum NONE()
 */
class JwaEnum extends Enum
{
    public const HS256 = 'HS256';
    public const HS384 = 'HS384';
    public const HS512 = 'HS512';
    public const RS256 = 'RS256';
    public const RS384 = 'RS384';
    public const RS512 = 'RS512';
    public const ES256 = 'ES256';
    public const ES384 = 'ES384';
    public const ES512 = 'ES512';
    public const PS256 = 'PS256';
    public const PS384 = 'PS384';
    public const PS512 = 'PS512';
    public const NONE = 'none';

    public function family(): JwaFamilyEnum
    {
        switch ($this->value) {
            case self::HS256:
            case self::HS384:
            case self::HS512:
                return JwaFamilyEnum::HS();
            case self::RS256:
            case self::RS384:
            case self::RS512:
                return JwaFamilyEnum::RS();
            case self::ES256:
            case self::ES384:
            case self::ES512:
                return JwaFamilyEnum::ES();
            case self::PS256:
            case self::PS384:
            case self::PS512:
                return JwaFamilyEnum::PS();
            case self::NONE:
                return JwaFamilyEnum::NONE();
            default:
                throw new UnrecognisedJwaException('The instantiated AlgorithmName is not recognised');
        }
    }

    public function hashingAlgorithm(): string
    {
        switch ($this->value) {
            case self::HS256:
            case self::RS256:
            case self::ES256:
            case self::PS256:
                return 'sha256';
            case self::HS384:
            case self::RS384:
            case self::ES384:
            case self::PS384:
                return 'sha384';
            case self::HS512:
            case self::RS512:
            case self::ES512:
            case self::PS512:
                return 'sha512';
            case self::NONE:
                throw new NoneAlgorithmException('Algorithm none has no hashing algorithm');
        }
    }

    public function ecdsaCurveValue(): string
    {
        switch ($this->value) {
            case self::ES256:
                return 'P-256';
            case self::ES384:
                return 'P-384';
            case self::ES512:
                return 'P-521';
            default:
                throw new InvalidAlgorithmException(
                    sprintf('%s is not a valid ECDSA JWA', $this->getValue())
                );
        }
    }

    public function ecdsaSignaturePartLength(): int
    {
        switch ($this->value) {
            case self::ES256:
                return 64;
            case self::ES384:
                return 96;
            case self::ES512:
                return 132;
            default:
                throw new InvalidAlgorithmException(
                    sprintf('%s is not a valid ECDSA JWA', $this->getValue())
                );
        }
    }

    public function hmacRequiredKeyLength(): int
    {
        switch ($this->value) {
            case self::HS256:
                return 32;
            case self::HS384:
                return 48;
            case self::HS512:
                return 64;
            default:
                throw new InvalidAlgorithmException(
                    sprintf('%s is not a valid HMAC JWA', $this->getValue())
                );
        }
    }
}