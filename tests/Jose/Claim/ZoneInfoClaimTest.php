<?php

declare(strict_types=1);

namespace IdentityLayer\Tests\Jose\Claim;

use IdentityLayer\Jose\Claim\ZoneInfoClaim;
use IdentityLayer\Jose\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ZoneInfoClaimTest extends TestCase
{
    public function testValidZoneInfo()
    {
        $validTimeZone = 'Europe/London';

        $zoneInfoClaim = ZoneInfoClaim::fromKeyValue('zoneinfo', $validTimeZone);
        $this->assertEquals($validTimeZone, $zoneInfoClaim->getValue());
        $this->assertEquals('zoneinfo', $zoneInfoClaim->getKey());
        $this->assertEquals(['zoneinfo' => 'Europe/London'], $zoneInfoClaim->jsonSerialize());
    }

    public function testInvalidZoneInfo()
    {
        $this->expectException(InvalidArgumentException::class);

        ZoneInfoClaim::fromKeyValue('zoneinfo', 'test');
    }
}