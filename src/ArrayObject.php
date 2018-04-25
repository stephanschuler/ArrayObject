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

    public function __call(string $methodName, array $arguments)
    {
        array_unshift($arguments, $this->toArray());
        $className = self::$method[$methodName];
        return new self($className(...$arguments));
    }

    public static function registerMethod(string $operatorClassName, string $methodName)
    {
        if (isset(self::$method[$methodName])) {
            throw new \Exception(sprintf('Method %s::%s() already registered.', get_called_class(), $methodName));
        }
        self::$method[$methodName] = [$operatorClassName, $methodName];
    }
}