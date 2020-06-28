<?php

declare(strict_types=1);

namespace IdentityLayer\Tests\Jose\Claim;

use IdentityLayer\Jose\Claim\LocaleClaim;
use PHPUnit\Framework\TestCase;

class LocaleClaimTest extends TestCase
{
    public function testValidLocales(): void
    {
        $validLocales = [
            'en-GB',
            'en-US',
            'de_DE',
            'es_ES',
            'fr-FR',
            'it-IT',
            'ja-JP',
            'zh-CN',
        ];

        foreach ($validLocales as $validLocale) {
            $localeFiltered = substr($validLocale, 0, 2) . '-' . substr($validLocale, 3);
            $localeClaim = LocaleClaim::fromKeyValue('test', $validLocale);
            $this->assertEquals(
                $localeFiltered,
                $localeClaim->getValue()
            );
            $this->assertEquals('test', $localeClaim->getKey());
            $this->assertEquals(['test' => $localeFiltered], $localeClaim->jsonSerialize());
        }
    }

    public function testInvalidLocale(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        LocaleClaim::fromKeyValue('test', 'not a locale');
    }
}
