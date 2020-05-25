<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwa;

use IdentityLayer\Jose\Exception\InvalidAlgorithmException;
use IdentityLayer\Jose\Jwa;
use IdentityLayer\Jose\JwaEnum;
use IdentityLayer\Jose\JwaFamilyEnum;

final class HS implements Jwa
{
    private JwaEnum $algorithm;

    public function __construct(JwaEnum $algorithm)
    {
        if (!$algorithm->family()->equals(JwaFamilyEnum::HS())) {
            throw new InvalidAlgorithmException(
                sprintf(
                    '%s is not a member of the HS family of JWA',
                    $algorithm->getValue()
                )
            );
        }

        $this->algorithm = $algorithm;
    }

    use JwaTrait;
}