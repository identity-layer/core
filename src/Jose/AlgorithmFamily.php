<?php

declare(strict_types=1);

namespace IdentityLayer\Jose;

use MyCLabs\Enum\Enum;

/**
 * Class AlgorithmType
 * @package IdentityLayer\Core\Jose
 *
 * @method static AlgorithmFamily HS()
 * @method static AlgorithmFamily RS()
 * @method static AlgorithmFamily ES()
 * @method static AlgorithmFamily PS()
 * @method static AlgorithmFamily NONE()
 */
class AlgorithmFamily extends Enum
{
    private const HS = 'HS';
    private const RS = 'RS';
    private const ES = 'ES';
    private const PS = 'PS';
    private const NONE = 'none';
}