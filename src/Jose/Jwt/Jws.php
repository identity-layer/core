<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwt;

use IdentityLayer\Jose\ClaimCollection;
use IdentityLayer\Jose\ClaimFactory;
use IdentityLayer\Jose\Exception\InvalidJwtException;
use IdentityLayer\Jose\Exception\InvalidSignatureException;
use IdentityLayer\Jose\Exception\JwaException;
use IdentityLayer\Jose\Jwa;
use IdentityLayer\Jose\JwaEnum;
use IdentityLayer\Jose\Jwk\SigningKey;
use IdentityLayer\Jose\Jwk\VerificationKey;
use IdentityLayer\Jose\Jwt;
use IdentityLayer\Jose\Util\Json;
use ParagonIE\ConstantTime\Base64UrlSafe;

class Jws implements Jwt
{
    private array $header;
    private ClaimCollection $claims;

    public function __construct(
        ClaimCollection $claims,
        array $header = []
    ) {
        $this->claims = $claims;
        $this->header = $header;
    }

    public static function fromCompactSerialisedFormat(VerificationKey $key, string $jwt): Jwt
    {
        $jwtParts = explode('.', $jwt);

        if (count($jwtParts) !== 3) {
            throw new InvalidJwtException('JWT is not in a valid compact serialised form.');
        }

        list($header, $payload) = array_map(function (string $part): array {
            return Json::decode(Base64UrlSafe::decode($part));
        }, [$jwtParts[0], $jwtParts[1]]);

        $jwaEnum = new JwaEnum($header['alg']);

        if (
            !$key->verify(
                $jwaEnum,
                "$jwtParts[0].$jwtParts[1]",
                Base64UrlSafe::decode($jwtParts[2])
            )
        ) {
            throw new InvalidSignatureException(
                'JWT does not have a valid signature according to the provided JWS'
            );
        }

        return new Jws(ClaimFactory::createClaims($payload), $header);
    }

    public function toCompactSerialisedFormat(Jwa $jwa, SigningKey $key): string
    {
        $header = array_merge($this->header, [
            'alg' => $jwa->name()->getValue(),
            'kid' => $key->kid(),
            'typ' => 'JWT',
        ]);

        $headerJson = Json::encode($header);

        $headerEncoded = Base64UrlSafe::encodeUnpadded($headerJson);

        $claimsJson = json_encode($this->claims);

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

    public function getClaims(): ClaimCollection
    {
        return $this->claims;
    }

    /**
     * @return array
     */
    public function getHeader(): array
    {
        return $this->header;
    }
}
