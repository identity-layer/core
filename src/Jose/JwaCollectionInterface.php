<?php

declare(strict_types=1);

namespace IdentityLayer\Core\Jose;

use Traversable;

interface JwaCollectionInterface extends Traversable
{
    /**
     * @return Jwa[]
     */
    public function items(): array;

    /**
     * @param Jwa $jwa
     * @return JwaCollectionInterface
     */
    public function withItem(Jwa $jwa): JwaCollectionInterface;

    /**
     * @param Jwa[] $items
     * @return JwaCollectionInterface
     */
    public static function fromArray(array $items): JwaCollectionInterface;

    /**
     * @return string
     */
    public function toJwks(): string;
}