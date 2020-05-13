<?php

declare(strict_types=1);

namespace IdentityLayer\Core\Jose\RegisteredClaim;

use IdentityLayer\Core\Jose\RegisteredClaimEnum;
use DateTimeImmutable;

trait TimestampClaimTrait
{
    private RegisteredClaimEnum $type;
    private DateTimeImmutable $value;

    private function __construct(RegisteredClaimEnum $type, DateTimeImmutable $time)
    {
        $this->type = $type;
        $this->value = $time;
    }

    public function getKey(): string
    {
        return $this->type->getValue();
    }

    public function getValue()
    {
        return $this->value->getTimestamp();
    }

    public function type(): RegisteredClaimEnum
    {
        return $this->type;
    }
}