<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwk;

use IdentityLayer\Jose\JwaEnum;
use IdentityLayer\Jose\Jwk;

interface SigningKey extends Jwk
{
    public function sign(JwaEnum $algorithmName, string $message): string;
}
