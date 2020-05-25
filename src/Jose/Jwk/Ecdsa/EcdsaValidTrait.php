<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwk\Ecdsa;

use IdentityLayer\Jose\Exception\InvalidAlgorithmException;
use IdentityLayer\Jose\Exception\InvalidArgumentException;
use IdentityLayer\Jose\JwaEnum;
use IdentityLayer\Jose\JwaFamilyEnum;

trait EcdsaValidTrait
{
    private function getCurveFromBits(int $bits): string
    {
        switch ($bits) {
            case 256:
                return 'P-256';
            case 384:
                return 'P-384';
            case 521:
                return 'P-521';
            default:
                throw new InvalidArgumentException('Key is not compatible with JWA spec.');
        }
    }

    private function validateAlgorithm(JwaEnum $algorithm, string $curve): void
    {
        if (!$algorithm->family()->equals(JwaFamilyEnum::ES())) {
            throw new InvalidAlgorithmException(
                sprintf(
                    '%s is not a valid algorithm for use with an ECDSA key',
                    $algorithm->getValue()
                )
            );
        }

        if ($algorithm->ecdsaCurveValue() !== $this->jwaCurve) {
            throw new InvalidAlgorithmException(
                sprintf(
                    '%s is not compatible with ECDSA key with curve %s.',
                    $algorithm->getValue(),
                    $this->jwaCurve
                )
            );
        }
    }
}