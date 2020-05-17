<?php

declare(strict_types=1);

namespace IdentityLayer\Jose;

class RegisteredClaim implements Claim
{
    private RegisteredClaimEnum $type;
    private Claim $claim;

    public function __construct(RegisteredClaimEnum $type, Claim $claim)
    {
        $this->type = $type;
        $this->claim = $claim;
    }

    public static function fromKeyValue(string $key, $value): Claim
    {
        $registeredClaimType = new RegisteredClaimEnum($key);
        return new static($registeredClaimType, $value);
    }

    public function type(): RegisteredClaimEnum
    {
        return $this->type;
    }

    public function getKey(): string
    {
        return $this->claim->getKey();
    }

    public function getValue()
    {
        return $this->claim->getValue();
    }

    public function jsonSerialize()
    {
        return $this->claim->jsonSerialize();
    }
}