<?php

declare(strict_types=1);

namespace IdentityLayer\Core\Jose\RegisteredClaim;

use IdentityLayer\Core\Jose\RegisteredClaim;
use IdentityLayer\Core\Jose\RegisteredClaimEnum;
use InvalidArgumentException;

class StringClaim extends RegisteredClaim
{
    private RegisteredClaimEnum $type;
    private string $value;

    private function __construct(RegisteredClaimEnum $type, string $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    public static function fromTypeAndValue(RegisteredClaimEnum $type, string $value): RegisteredClaim
    {
        return new static($type, $value);
    }

    public function getKey(): string
    {
        return $this->type->getValue();
    }

    public function getValue()
    {
        return $this->value;
    }

    public function type(): RegisteredClaimEnum
    {
        return $this->type;
    }
}