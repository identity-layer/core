<?php

declare(strict_types=1);

namespace IdentityLayer\Tests\Jose\Jwk\Hmac;

use IdentityLayer\Jose\JwaEnum;
use IdentityLayer\Jose\Jwk\Hmac\Hmac;
use IdentityLayer\Jose\Jwk\Hmac\Hmac384;
use IdentityLayer\Jose\Jwk\Hmac\Hmac512;
use ParagonIE\ConstantTime\Base64UrlSafe;
use PHPUnit\Framework\TestCase;

/**
 * These tests were generated using known signature values for a particular key and ensuring this
 * implementation returns expected results.
 */
class HmacTest extends TestCase
{
    public function testSignatureGenerationWithAllHmacVariants(): void
    {
        $message256 = file_get_contents(__DIR__ . '/message256');
        $expectedSignature = 'LymGnxhOWevapacuiYbxRibRINCqHOa_oCtZ0MBxIrI';
        $jwk = Hmac::fromKidAndKey('1', 'y:¹£ö;"T.Gvš×äâÖåUgøé!œ¡%ôÍ');
        $this->assertEquals(
            $expectedSignature,
            Base64UrlSafe::encodeUnpadded(
                $jwk->sign(JwaEnum::HS256(), $message256)
            )
        );

        $message384 = file_get_contents(__DIR__ . '/message384');
        $expectedSignature = '2_ScYSRmK_GBZ7LkwcCk8X2on-CbtUoq14edumYQnqlAsR8i5I2b2Qm6LF0OSwyL';
        $jwk = Hmac::fromKidAndKey('2', 'ⵇ頞샴揎庋騒䦘뎌誾﯎̀ቲ谀຅䘖꺹ㄏඞ嚙鶲⑐澤');
        $this->assertEquals(
            $expectedSignature,
            Base64UrlSafe::encodeUnpadded(
                $jwk->sign(JwaEnum::HS384(), $message384)
            )
        );

        $message512 = file_get_contents(__DIR__ . '/message512');
        $expectedSignature = 'TpLSjCoaJ9Zl95TVT5f9xh-H8BnD6XbgOojzXFgu5Tm8fthxMbiaNlQYHUgB1gtfRrYcR95nrZLaix2hClrGuA';
        $jwk = Hmac::fromKidAndKey('3', '降驱쓑በꠊ翟溊㊓툀ᇐ霋㔀΍捜뮨ʑ䦻ᔱ铗ꦛ枩鷠烀矾鮟ꥏ鹿凯궑鐍');
        $this->assertEquals(
            $expectedSignature,
            Base64UrlSafe::encodeUnpadded(
                $jwk->sign(JwaEnum::HS512(), $message512)
            )
        );
    }
}
