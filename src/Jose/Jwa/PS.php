<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwa;

use IdentityLayer\Jose\Exception\NotImplementedException;
use IdentityLayer\Jose\Jwa;

final class PS implements Jwa
{
    use JwaTrait;

    public function __construct()
    {
        throw new NotImplementedException('This algorithm has not been implemented. This ' .
            'library is still in an experimental state and should be used with caution in any ' .
            'production environment');
    }
}
