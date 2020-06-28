<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Util;

use IdentityLayer\Jose\Exception\EncodingException;
use Exception;

final class Json
{
    /**
     * @throws EncodingException
     */
    public static function encode(array $data): string
    {
        try {
            return json_encode($data, JSON_THROW_ON_ERROR);
        } catch (Exception $e) {
            throw new EncodingException(
                sprintf(
                    'The following error occurred while encoding JSON data: %s',
                    $e->getMessage()
                )
            );
        }
    }

    /**
     * @throws EncodingException
     */
    public static function decode(string $data): array
    {
        try {
            return json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        } catch (Exception $e) {
            throw new EncodingException(
                sprintf(
                    'The following error occurred while decoding JSON data: %s',
                    $e->getMessage()
                )
            );
        }
    }
}
