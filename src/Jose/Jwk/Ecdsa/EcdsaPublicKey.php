<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwk\Ecdsa;

use IdentityLayer\Jose\Exception\InvalidArgumentException;
use IdentityLayer\Jose\JwaEnum;
use IdentityLayer\Jose\Jwk\JwkSerialisable;
use IdentityLayer\Jose\Jwk\VerificationKey;
use ParagonIE\ConstantTime\Base64UrlSafe;

class EcdsaPublicKey implements VerificationKey, JwkSerialisable
{
    private $keyResource;
    private string $x;
    private string $y;
    private string $jwaCurve;
    private string $pemEncoded;

    use EcdsaValidTrait;

    private function __construct(string $pemEncodedKey)
    {
        $keyResource = openssl_get_publickey($pemEncodedKey);

        if ($keyResource === false) {
            throw new InvalidArgumentException('public key is not valid');
        }

        $details = openssl_pkey_get_details($keyResource);

        if ($details === false) {
            throw new InvalidArgumentException('Key is not an RSA public key');
        }

        $this->jwaCurve = $this->getCurveFromBits($details['bits']);

        $this->keyResource = $keyResource;
        $this->x = $details['ec']['x'];
        $this->y = $details['ec']['y'];
        $this->pemEncoded = $details['key'];
    }

    public static function fromPublicKeyPemEncoded(string $publicKeyPemEncoded): EcdsaPublicKey
    {
        return new static($publicKeyPemEncoded);
    }

    public function toJwkFormat(): string
    {
        return json_encode([
            'crv' => $this->jwaCurve ,
            'kty' => 'EC',
            'x' => $this->x,
            'y' => $this->y,
        ]);
    }

    public function kid(): string
    {
        $base = [
            'crv' => $this->jwaCurve,
            'kty' => 'EC',
            'x' => Base64UrlSafe::encodeUnpadded($this->x),
            'y' => Base64UrlSafe::encodeUnpadded($this->y),
        ];

        $baseJsonEncoded = json_encode($base);

        return Base64UrlSafe::encodeUnpadded(
            hash('sha256', $baseJsonEncoded, true)
        );
    }

    public function verify(JwaEnum $algorithmName, string $message, string $signature): bool
    {
        $this->validateAlgorithm($algorithmName, $this->jwaCurve);

        return openssl_verify(
                $message,
                $signature,
                $this->keyResource,
                $algorithmName->hashingAlgorithm()
            ) === 1;
    }
}