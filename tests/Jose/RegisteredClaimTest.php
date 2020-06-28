<?php

declare(strict_types=1);

namespace IdentityLayer\Tests\Jose;

use IdentityLayer\Jose\Claim\GenericClaim;
use IdentityLayer\Jose\RegisteredClaim;
use IdentityLayer\Jose\RegisteredClaimEnum;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class RegisteredClaimTest extends TestCase
{
    public function testWithRegisteredKey(): void
    {
        $mockClaim = $this->createMock(GenericClaim::class);

        foreach (RegisteredClaimEnum::toArray() as $key) {
            $registeredClaim = RegisteredClaim::fromKeyValue($key, $mockClaim);
            $this->assertEquals($key, $registeredClaim->getKey());
        }
    }

    public function testWithUnregisteredKey(): void
    {
        $mockClaim = $this->createMock(GenericClaim::class);
        $this->expectException(\UnexpectedValueException::class);
        RegisteredClaim::fromKeyValue('randomKey', $mockClaim);
    }
}
