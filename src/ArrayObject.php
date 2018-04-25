<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject;

class ArrayObject
{
    private static $method = [];

    private $storage = [];

    public function __construct(array $data = [])
    {
        $this->storage = $data;
    }

    public function getArrayCopy(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return $this->storage;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->toArray());
    }
}