<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwa;

use IdentityLayer\Jose\Exception\InvalidAlgorithmException;
use IdentityLayer\Jose\Jwa;
use IdentityLayer\Jose\JwaEnum;
use IdentityLayer\Jose\JwaFamilyEnum;

final class RS implements Jwa
{
    use JwaTrait;

    public function __construct(JwaEnum $algorithm)
    {
        if (!$algorithm->family()->equals(JwaFamilyEnum::RS())) {
            throw new InvalidAlgorithmException(
                sprintf(
                    '%s is not a member of the RS family of JWA',
                    $algorithm->getValue()
                )
            );
        }

        $this->algorithm = $algorithm;
    }
}
