<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwk\Rsa;

use IdentityLayer\Jose\JwaFamilyEnum;
use IdentityLayer\Jose\JwaEnum;
use IdentityLayer\Jose\Exception\InvalidAlgorithmException;
use IdentityLayer\Jose\Exception\InvalidArgumentException;
use IdentityLayer\Jose\Jwk\JwkSerialisable;
use IdentityLayer\Jose\Jwk\VerificationKey;
use ParagonIE\ConstantTime\Base64UrlSafe;

final class PublicKey implements VerificationKey, JwkSerialisable
{
    private const ASN1_SEQUENCE = 48;
    private const ASN1_INTEGER = 2;

    private $keyResource;
    private string $publicExponent;
    private string $modulus;
    private string $pemEncoded;

    private function __construct(string $pemEncodedKey)
    {
        $keyResource = openssl_pkey_get_public($pemEncodedKey);

        if ($keyResource === false) {
            throw new InvalidArgumentException('public key is not valid');
        }

        $details = openssl_pkey_get_details($keyResource);

        if ($details === false) {
            throw new InvalidArgumentException('Key is not an RSA public key');
        }

        $this->keyResource = $keyResource;
        $this->modulus = $details['rsa']['n'];
        $this->publicExponent = $details['rsa']['e'];
        $this->pemEncoded = $details['key'];
    }

    public static function fromPublicKeyPemEncoded(string $publicKeyPemEncoded): PublicKey
    {
        return new PublicKey($publicKeyPemEncoded);
    }

    public function kid(): string
    {
        $base = [
            'e' => Base64UrlSafe::encodeUnpadded($this->publicExponent),
            'kty' => 'RSA',
            'n' => Base64UrlSafe::encodeUnpadded($this->modulus),
        ];

        $baseJsonEncoded = json_encode($base);

        return Base64UrlSafe::encodeUnpadded(
            hash('sha256', $baseJsonEncoded, true)
        );
    }

    public function toJwkFormat(): string
    {
        return json_encode([
            'kty' => 'RSA',
            'use' => 'sig',
            'kid' => $this->kid(),
            'n' => Base64UrlSafe::encodeUnpadded($this->modulus),
            'e' => Base64UrlSafe::encodeUnpadded($this->publicExponent),
        ]);
    }

    private static function lengthEncodedToUnsignedLong(int $length): string
    {
        if ($length <= 0x7F) {
            return chr($length);
        }

        $unsignedLongPacked = ltrim(pack('N', $length), chr(0));

        return pack('Ca*', 0x80 | strlen($unsignedLongPacked), $unsignedLongPacked);
    }

    public static function fromJwkData(array $data): PublicKey
    {
        $modulus = Base64UrlSafe::decode($data['n']);
        $publicExponent = Base64UrlSafe::decode($data['e']);

        $components = [
            'modulus' => pack(
                'Ca*a*',
                self::ASN1_INTEGER,
                static::lengthEncodedToUnsignedLong(strlen($modulus)),
                $modulus
            ),
            'publicExponent' => pack(
                'Ca*a*',
                self::ASN1_INTEGER,
                static::lengthEncodedToUnsignedLong(strlen($publicExponent)),
                $publicExponent
            )
        ];

        $publicKey = pack(
            'Ca*a*a*',
            self::ASN1_SEQUENCE,
            static::lengthEncodedToUnsignedLong(
                strlen($components['modulus']) + strlen($components['publicExponent'])
            ),
            $components['modulus'],
            $components['publicExponent']
        );

        $rsaOID = pack('H*', '300d06092a864886f70d0101010500');
        $publicKey = chr(0) . $publicKey;
        $publicKey = chr(3) . static::lengthEncodedToUnsignedLong(strlen($publicKey)) . $publicKey;

        $publicKey = pack(
            'Ca*a*',
            self::ASN1_SEQUENCE,
            static::lengthEncodedToUnsignedLong(strlen($rsaOID . $publicKey)),
            $rsaOID . $publicKey
        );

        $publicKeyPemEncoded = "-----BEGIN PUBLIC KEY-----\r\n" .
            chunk_split(base64_encode($publicKey), 64) .
            '-----END PUBLIC KEY-----';

        return new PublicKey($publicKeyPemEncoded);
    }

    public function toString(): string
    {
        return $this->pemEncoded;
    }

    public function verify(
        JwaEnum $algorithmName,
        string $message,
        string $signature
    ): bool {

        if (!$algorithmName->family()->equals(JwaFamilyEnum::RS())) {
            throw new InvalidAlgorithmException(
                sprintf(
                    '%s is not a valid algorithm for use with an RSA key',
                    $algorithmName->getValue()
                )
            );
        }

        return openssl_verify(
            $message,
            $signature,
            $this->keyResource,
            $algorithmName->hashingAlgorithm()
        ) === 1;
    }
}