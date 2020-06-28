<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwt;

use IdentityLayer\Jose\ClaimCollection;
use IdentityLayer\Jose\Exception\JwaException;
use IdentityLayer\Jose\Jwa;
use IdentityLayer\Jose\Jwk\SigningKey;
use IdentityLayer\Jose\Jwt;
use ParagonIE\ConstantTime\Base64UrlSafe;

class Jws implements Jwt
{
    public static function toCompactSerialisedFormat(
        SigningKey $key,
        Jwa $jwa,
        ClaimCollection $claims,
        array $header = null
    ): string {
        $header = $header ?? [
            'alg' => $jwa->name()->getValue(),
            'kid' => $key->kid(),
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
            $jwa->sign($key, "{$headerEncoded}.{$payloadEncoded}")
        );

        return "{$headerEncoded}.{$payloadEncoded}.{$signature}";
    }
}
