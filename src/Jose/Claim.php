<?php

declare(strict_types=1);

namespace IdentityLayer\Jose;

use JsonSerializable;

interface Claim extends JsonSerializable
{
    /**
     * @param string $key
     * @param mixed $value
     * @return Claim
     */
    public static function fromKeyValue(string $key, $value): Claim;
    public function getKey(): string;

    /**
     * @return mixed
     */
    public function getValue();
}
