<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Claim;

use IdentityLayer\Jose\Claim;
use IdentityLayer\Jose\Exception\InvalidArgumentException;

class UrlClaim implements Claim
{
    private string $key;
    private string $value;

    private function __construct(string $key, string $url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException(
                sprintf('%s is not a valid Url', $url)
            );
        }

        $this->key = $key;
        $this->value = $url;
    }

    /**
     * @param string $key
     * @param string $value
     * @return Claim
     */
    public static function fromKeyValue(string $key, $value): Claim
    {
        return new UrlClaim($key, $value);
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue()
    {
        return (string) $this->value;
    }

    public function jsonSerialize(): array
    {
        return [
            $this->key => $this->value
        ];
    }
}
