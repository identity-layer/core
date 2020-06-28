<?php

declare(strict_types=1);

namespace IdentityLayer\Tests\Jose\Claim;

use IdentityLayer\Jose\Claim\UrlClaim;
use IdentityLayer\Jose\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class UrlClaimTest extends TestCase
{
    public function testValidUrl(): void
    {
        $validUrl = 'https://example.com';

        $urlClaim = UrlClaim::fromKeyValue('profile', $validUrl);
        $this->assertEquals($validUrl, $urlClaim->getValue());
        $this->assertEquals('profile', $urlClaim->getKey());
        $this->assertEquals(['profile' => $validUrl], $urlClaim->jsonSerialize());
    }

    public function testInvalidUrl(): void
    {
        $this->expectException(InvalidArgumentException::class);

        UrlClaim::fromKeyValue('website', 'some-bad-url');
    }
}
