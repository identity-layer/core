<?php

declare(strict_types=1);

namespace IdentityLayer\Core\Jose;

use IdentityLayer\Core\Jose\Exception\NoneHashingAlgorithmException;
use IdentityLayer\Core\Jose\Exception\UnrecognisedJwaException;
use MyCLabs\Enum\Enum;

/**
 * Class AlgorithmName
 * @package IdentityLayer\Core\Jose
 * @method static AlgorithmName HS256()
 * @method static AlgorithmName HS384()
 * @method static AlgorithmName HS512()
 * @method static AlgorithmName RS256()
 * @method static AlgorithmName RS384()
 * @method static AlgorithmName RS512()
 * @method static AlgorithmName ES256()
 * @method static AlgorithmName ES384()
 * @method static AlgorithmName ES512()
 * @method static AlgorithmName PS256()
 * @method static AlgorithmName PS384()
 * @method static AlgorithmName PS512()
 * @method static AlgorithmName NONE()
 */
class AlgorithmName extends Enum
{
    private const HS256 = 'HS256';
    private const HS384 = 'HS384';
    private const HS512 = 'HS512';
    private const RS256 = 'RS256';
    private const RS384 = 'RS384';
    private const RS512 = 'RS512';
    private const ES256 = 'ES256';
    private const ES384 = 'ES384';
    private const ES512 = 'ES512';
    private const PS256 = 'PS256';
    private const PS384 = 'PS384';
    private const PS512 = 'PS512';
    private const NONE = 'none';

    public function algorithmType(): AlgorithmFamily
    {
        switch ($this->value) {
            case self::HS256:
            case self::HS384:
            case self::HS512:
                return AlgorithmFamily::HS();
            case self::RS256:
            case self::RS384:
            case self::RS512:
                return AlgorithmFamily::RS();
            case self::ES256:
            case self::ES384:
            case self::ES512:
                return AlgorithmFamily::ES();
            case self::PS256:
            case self::PS384:
            case self::PS512:
                return AlgorithmFamily::PS();
            case self::NONE:
                return AlgorithmFamily::NONE();
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
                throw new NoneHashingAlgorithmException('Algorithm none has no hashing algorithm');
        }
    }
}