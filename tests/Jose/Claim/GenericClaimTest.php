<?php

declare(strict_types=1);

namespace IdentityLayer\Tests\Jose\Claim;

use IdentityLayer\Jose\Claim\GenericClaim;
use PHPUnit\Framework\TestCase;

class GenericClaimTest extends TestCase
{
    public function testGenericClaim(): void
    {
        $validJsonValues = [
            'string',
            12345,
            3.14159265359,
            null,
            [1, 2, 3, 4, 5],
            [
                'test' => [
                    'test' => 1,
                    'test2' => 'value',
                ]
            ],
        ];

        foreach ($validJsonValues as $validJsonValue) {
            $genericClaim = GenericClaim::fromKeyValue('test', $validJsonValue);
            $this->assertEquals($validJsonValue, $genericClaim->getValue());
            $this->assertEquals(['test' => $validJsonValue], $genericClaim->jsonSerialize());
        }
    }
}
