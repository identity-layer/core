<?php

declare(strict_types=1);

namespace IdentityLayer\Core\Jose;

use JsonSerializable;

interface Claim extends JsonSerializable
{
    public static function fromKeyValue(string $key, $value): Claim;
    public function getKey(): string;
    public function getValue();
}