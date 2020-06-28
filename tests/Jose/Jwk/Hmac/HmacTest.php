<?php

declare(strict_types=1);

namespace IdentityLayer\Tests\Jose\Jwk\Hmac;

use IdentityLayer\Jose\JwaEnum;
use IdentityLayer\Jose\Jwk;
use IdentityLayer\Jose\Jwk\Hmac\Hmac;
use ParagonIE\ConstantTime\Base64UrlSafe;
use PHPUnit\Framework\TestCase;

/**
 * These tests were generated using known signature values for a particular key and ensuring this
 * implementation returns expected results.
 */
class HmacTest extends TestCase
{
    private Jwk $key256;
    private Jwk $key384;
    private Jwk $key512;

    private string $message256;
    private string $message384;
    private string $message512;

    private string $signature256;
    private string $signature384;
    private string $signature512;

    public function setup(): void
    {
        $this->key256 = Hmac::fromKidAndKey('1', 'y:¹£ö;"T.Gvš×äâÖåUgøé!œ¡%ôÍ');
        $this->key384 = Hmac::fromKidAndKey('2', 'ⵇ頞샴揎庋騒䦘뎌誾﯎̀ቲ谀຅䘖꺹ㄏඞ嚙鶲⑐澤');
        $this->key512 = Hmac::fromKidAndKey('3', '降驱쓑በꠊ翟溊㊓툀ᇐ霋㔀΍捜뮨ʑ䦻ᔱ铗ꦛ枩鷠烀矾鮟ꥏ鹿凯궑鐍');

        $this->message256 = file_get_contents(__DIR__ . '/message256');
        $this->message384 = file_get_contents(__DIR__ . '/message384');
        $this->message512 = file_get_contents(__DIR__ . '/message512');

        $this->signature256 = 'LymGnxhOWevapacuiYbxRibRINCqHOa_oCtZ0MBxIrI';
        $this->signature384 = '2_ScYSRmK_GBZ7LkwcCk8X2on-CbtUoq14edumYQnqlAsR8i5I2b2Qm6LF0OSwyL';
        $this->signature512 = 'TpLSjCoaJ9Zl95TVT5f9xh-H8BnD6XbgOojzXFgu5Tm8fthxMbiaNlQYHUgB1gtfRrYcR95nrZLaix2hClrGuA';
    }

    public function testSignatureGenerationWithAllHmacVariants(): void
    {
        $this->assertEquals(
            $this->signature256,
            Base64UrlSafe::encodeUnpadded(
                $this->key256->sign(JwaEnum::HS256(), $this->message256)
            )
        );

        $this->assertEquals(
            $this->signature384,
            Base64UrlSafe::encodeUnpadded(
                $this->key384->sign(JwaEnum::HS384(), $this->message384)
            )
        );

        $this->assertEquals(
            $this->signature512,
            Base64UrlSafe::encodeUnpadded(
                $this->key512->sign(JwaEnum::HS512(), $this->message512)
            )
        );
    }

    public function testSignatureVerification(): void
    {
        $this->assertTrue(
            $this->key256->verify(
                JwaEnum::HS256(),
                $this->message256,
                Base64UrlSafe::decode($this->signature256)
            )
        );

        $this->assertTrue(
            $this->key384->verify(
                JwaEnum::HS384(),
                $this->message384,
                Base64UrlSafe::decode($this->signature384)
            )
        );

        $this->assertTrue(
            $this->key512->verify(
                JwaEnum::HS512(),
                $this->message512,
                Base64UrlSafe::decode($this->signature512)
            )
        );
    }
}
