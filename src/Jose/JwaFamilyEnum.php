<?php

declare(strict_types=1);

namespace IdentityLayer\Jose;

use MyCLabs\Enum\Enum;

/**
 * Class AlgorithmType
 * @package IdentityLayer\Core\Jose
 *
 * @method static JwaFamilyEnum HS()
 * @method static JwaFamilyEnum RS()
 * @method static JwaFamilyEnum ES()
 * @method static JwaFamilyEnum PS()
 * @method static JwaFamilyEnum NONE()
 */
class JwaFamilyEnum extends Enum
{
    private const HS = 'HS';
    private const RS = 'RS';
    private const ES = 'ES';
    private const PS = 'PS';
    private const NONE = 'none';
}