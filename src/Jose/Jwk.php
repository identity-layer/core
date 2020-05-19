<?php

declare(strict_types=1);

namespace IdentityLayer\Jose;

interface Jwk
{
    public function kid(): string;
    public function toJwkFormat(): string;
}