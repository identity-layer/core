<?php

declare(strict_types=1);

namespace IdentityLayer\Tests\Jose\Claim;

use IdentityLayer\Jose\Claim\TimestampClaim;
use PHPUnit\Framework\TestCase;

class TimestampClaimTest extends TestCase
{
    public function testValidTimestamp(): void
    {
        $validTimestamp = 1589958480;

        $expirationClaim = TimestampClaim::fromKeyValue('exp', $validTimestamp);
        $this->assertEquals('exp', $expirationClaim->getKey());
        $this->assertEquals($validTimestamp, $expirationClaim->getValue());
        $this->assertEquals(['exp' => $validTimestamp], $expirationClaim->jsonSerialize());
    }
}
