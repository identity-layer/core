<?php

declare(strict_types=1);

namespace IdentityLayer\Jose;

use IdentityLayer\Jose\Claim\GenericClaim;
use InvalidArgumentException;

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
        if (!$value instanceof Claim) {
            throw new InvalidArgumentException(
                sprintf('$value must be of type %s', Claim::class)
            );
        }

        $registeredClaimType = new RegisteredClaimEnum($key);
        return new RegisteredClaim($registeredClaimType, $value);
    }

    public function type(): RegisteredClaimEnum
    {
        return $this->type;
    }

    public function getKey(): string
    {
        return $this->type->getValue();
    }

    public function getValue()
    {
        return $this->claim->getValue();
    }

    public function jsonSerialize(): array
    {
        return $this->claim->jsonSerialize();
    }
}
