<?php

declare(strict_types=1);

namespace IdentityLayer\Tests\Jose\Claim;

use IdentityLayer\Jose\Claim\PhoneNumberClaim;
use IdentityLayer\Jose\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PhoneNumberClaimTest extends TestCase
{
    public function testValidPhoneNumber()
    {
        $validPhoneNumbers = [
            '+1 202 555 0174',
            '+442079461234',
            '+8604706874227'
        ];

        foreach ($validPhoneNumbers as $validPhoneNumber) {
            $phoneNumberClaim = PhoneNumberClaim::fromKeyValue('phone', $validPhoneNumber);
            $this->assertEquals($validPhoneNumber, $phoneNumberClaim->getValue());
        }
    }

    public function testInvalidPhoneNumber()
    {
        $this->expectException(InvalidArgumentException::class);
        PhoneNumberClaim::fromKeyValue('phone', '12345');
    }
}