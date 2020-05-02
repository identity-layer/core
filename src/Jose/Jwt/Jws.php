<?php

declare(strict_types=1);

namespace IdentityLayer\Core\Jose\Jwt;

use IdentityLayer\Core\Jose\Exception\JwaException;
use IdentityLayer\Core\Jose\Jwa;
use IdentityLayer\Core\Jose\Jwt;
use ParagonIE\ConstantTime\Base64UrlSafe;

class Jws implements Jwt
{
    public static function toCompactSerialisedFormat(Jwa $jwa, array $claims, array $header = null): string
    {
        $header = $header ?? [
            'alg' => $jwa->name()->getValue(),
            'kid' => $jwa->kid(),
            'typ' => 'JWT',
        ];

        $headerJson = json_encode($header);

        if ($headerJson === false) {
            throw new JwaException('Could not JSON encode the token header data.');
        }

        $headerEncoded = Base64UrlSafe::encodeUnpadded($headerJson);

        $claimsJson = json_encode($claims);

        if ($claimsJson === false) {
            throw new JwaException('Could not JSON encode the set of claims provided.');
        }

        $payloadEncoded = Base64UrlSafe::encodeUnpadded(
            $claimsJson
        );

        $signature = Base64UrlSafe::encodeUnpadded(
            $jwa->sign("{$headerEncoded}.{$payloadEncoded}")
        );

        return "{$headerEncoded}.{$payloadEncoded}.{$signature}";
    }
}