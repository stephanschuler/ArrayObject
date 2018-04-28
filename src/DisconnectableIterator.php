<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

class DisconnectableIterator implements IteratorAggregate
{
    /**
     * @var Traversable[]
     */
    private static $iterators = [];

    private static $identityCount = 0;

    private $identity;

    public function __construct(Traversable $iterator)
    {
        $this->identity = self::$identityCount++;
        self::$iterators[$this->identity] = $iterator;
    }

    public function __destruct()
    {
        unset(self::$iterators[$this->identity]);
    }

    public function __clone()
    {
        $source = self::$iterators[$this->identity];

        $target1 = self::$iterators[$this->identity] = new ArrayIterator();
        $this->identity = self::$identityCount++;
        $target2 = self::$iterators[$this->identity] = new ArrayIterator();

        foreach ($source as $key => $value) {
            $target1[$key] = $value;
            $target2[$key] = $value;
        }
    }

    public function getIterator(): Traversable
    {
        return self::$iterators[$this->identity];
    }

    public function toArray(): array
    {
        return iterator_to_array($this->getIterator());
    }

    public function disconnect(): DisconnectableIterator
    {
        return clone $this;
    }
}