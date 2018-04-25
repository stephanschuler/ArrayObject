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
        self::preventMethod($methodName);
        $callable = self::$method[$methodName];
        return new self(
            $callable(
                $this->toArray(),
                ...$arguments
            )
        );
    }

    public static function __callStatic(string $methodName, array $arguments): callable
    {
        self::preventMethod($methodName);
        $callable = self::$method[$methodName];
        return function (array $data) use ($callable, $arguments) {
            return $callable($data, ...$arguments);
        };
    }

    public static function registerMethod(callable $method, string $methodName)
    {
        if (isset(self::$method[$methodName])) {
            throw new \Exception(sprintf('Method %s::%s() already registered.', get_called_class(), $methodName));
        }
        self::$method[$methodName] = $method;
    }

    protected static function preventMethod(string $methodName)
    {
        if (!array_key_exists($methodName, self::$method)) {
            throw new \BadMethodCallException(
                sprintf('Call to undefined method %s::%s()".', get_called_class(), $methodName),
                1524688036
            );
        }
    }
}