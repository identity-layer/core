<?php

declare(strict_types=1);

namespace IdentityLayer\Core\Jose;

abstract class RegisteredClaim implements Claim
{
    abstract public function type(): RegisteredClaimEnum;

    public function jsonSerialize()
    {
        return [
            $this->type()->getValue()   => $this->getValue()
        ];
    }
}