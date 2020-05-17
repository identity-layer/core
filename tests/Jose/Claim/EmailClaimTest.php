<?php

declare(strict_types=1);

namespace IdentityLayer\Tests\Jose\Claim;

use IdentityLayer\Jose\Claim\EmailClaim;
use PHPUnit\Framework\TestCase;

class EmailClaimTest extends TestCase
{
    public function testWithValidEmail()
    {
        $validEmail = 'joe@bloggs.com';
        $emailClaim = EmailClaim::fromKeyValue('test', $validEmail);

        $this->assertEquals($validEmail, $emailClaim->getValue());
        $this->assertEquals('test', $emailClaim->getKey());
        $this->assertEquals(['test' => $validEmail], $emailClaim->jsonSerialize());
    }

    public function testWithInvalidEmail()
    {
        $this->expectException(\InvalidArgumentException::class);

        $invalidEmail = 'invalid.email';
        $emailClaim = EmailClaim::fromKeyValue('test', $invalidEmail);
    }
}