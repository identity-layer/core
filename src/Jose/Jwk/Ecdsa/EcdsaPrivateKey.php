<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwk\Ecdsa;

use IdentityLayer\Jose\Exception\InvalidArgumentException;
use IdentityLayer\Jose\Exception\SigningException;
use IdentityLayer\Jose\JwaEnum;
use IdentityLayer\Jose\Jwk\SigningKey;
use ParagonIE\ConstantTime\Base64UrlSafe;

class EcdsaPrivateKey implements SigningKey
{
    private $keyResource;
    private GMP $x;
    private string $y;
    private string $d;
    private string $jwaCurve;
    private string $pemEncoded;

    use EcdsaValidTrait;

    private function __construct(string $pemEncodedKey)
    {
        $keyResource = openssl_get_privatekey($pemEncodedKey);

        if ($keyResource === false) {
            throw new InvalidArgumentException('private key is not valid');
        }

        $details = openssl_pkey_get_details($keyResource);

        if ($details === false) {
            throw new InvalidArgumentException('Key is not an RSA public key');
        }

        $this->jwaCurve = $this->getCurveFromBits($details['bits']);
        $this->keyResource = $keyResource;
        $this->x = $details['ec']['x'];
        $this->y = $details['ec']['y'];
        $this->d = $details['ec']['d'];
        $this->pemEncoded = $details['key'];
    }

    public static function fromPrivateKeyPemEncoded(string $privateKeyPemEncoded): EcdsaPrivateKey
    {
        return new static($privateKeyPemEncoded);
    }

    public static function fromJwk(array $data): EcdsaPrivateKey
    {
        $head = hex2bin('302e0201010420');

    }

    public function toString(): string
    {

    }

    public function kid(): string
    {
        $base = [
            'crv' => $this->jwaCurve,
            'kty' => 'EC',
            'x' => $this->x,
            'y' => $this->y,
        ];

        $baseJsonEncoded = json_encode($base);

        return Base64UrlSafe::encodeUnpadded(
            hash('sha256', $baseJsonEncoded, true)
        );
    }

    public function sign(JwaEnum $algorithmName, string $message): string
    {
        $this->validateAlgorithm($algorithmName, $this->jwaCurve);

        $signature = null;
        $result = openssl_sign(
            $message,
            $signature,
            $this->keyResource,
            $algorithmName->hashingAlgorithm()
        );

        if ($result === false || $signature === null) {
            throw new SigningException('An unexpected error occurred while attempting to sign ' .
                'message with private key.');
        }

        return $signature;
    }

    public function verify(JwaEnum $algorithmName, string $message, string $signature): bool
    {
        return $this->sign($algorithmName, $message) === $signature;
    }
}