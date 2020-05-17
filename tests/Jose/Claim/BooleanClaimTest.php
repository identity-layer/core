<?php

declare(strict_types=1);

namespace IdentityLayer\Tests\Jose\Claim;

use IdentityLayer\Jose\Claim\BooleanClaim;
use PHPUnit\Framework\TestCase;
use TypeError;

class BooleanClaimTest extends TestCase
{
    public function testValues()
    {
        $trueClaim = BooleanClaim::fromKeyValue('test1', true);
        $falseClaim = BooleanClaim::fromKeyValue('test2', false);

        $this->assertTrue($trueClaim->getValue());
        $this->assertEquals('test1', $trueClaim->getKey());
        $this->assertEquals(['test1' => true], $trueClaim->jsonSerialize());

        $this->assertFalse($falseClaim->getValue());
        $this->assertEquals('test2', $falseClaim->getKey());
        $this->assertEquals(['test2' => false], $falseClaim->jsonSerialize());
    }
}