<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject;

use Countable;
use Generator;
use IteratorAggregate;
use StephanSchuler\ArrayObject\Exception\CloningDisabledException;
use Traversable;

class ArrayObject implements IteratorAggregate, Countable
{
    /**
     * @var callable[]
     */
    private static $method = [];

    /**
     * @var bool
     */
    private static $isCloningAllowed = false;

    /**
     * @var Traversable
     */
    private $storage;

    /**
     * @var bool
     */
    private $connected = true;

    public function __construct(Traversable $data)
    {
        $this->storage = new DisconnectableIterator($data);
    }

    public function __call(string $methodName, array $arguments)
    {
        if ($this->connected) {
            $this->storage = $this->mutateIterator($methodName, $arguments);
            return $this;
        } else {
            $className = get_called_class();
            return new $className($this->mutateIterator($methodName, $arguments));
        }
    }

    public function __clone()
    {
        if (!self::$isCloningAllowed) {
            throw new CloningDisabledException(sprintf(
                'Cloning of %s objects is disabled, use %1$s::withCloningAllowed() to temporary enable cloningf',
                get_called_class()
            ), 1525011441);
        }
        $this->storage = clone $this->storage;
    }

    public function connect()
    {
        $this->connected = true;
        return $this;
    }

    public function disconnect()
    {
        $this->connected = false;
        return clone $this;
    }

    public function count(): int
    {
        $data = $this->getIterator();
        if ($data instanceof Countable) {
            return $data->count();
        } else {
            $number = 0;
            foreach ($data as $value) {
                $number++;
            }
            return $number;
        }
    }

    public function getIterator(): Generator
    {
        foreach ($this->storage as $key => $value) {
            yield $key => $value;
        }
    }

    public function getArrayCopy()
    {
        return iterator_to_array($this->getIterator());
    }

    public static function registerMethod(callable $method, string $methodName)
    {
        if (isset(self::$method[$methodName])) {
            throw new \Exception(sprintf('Cannot redeclare %s::%s().', get_called_class(), $methodName));
        }
        self::$method[$methodName] = $method;
    }

    public static function fromArray(array $data): ArrayObject
    {
        return self::fromIterator(new \ArrayIterator($data));
    }

    public static function fromIterator(Traversable $data): ArrayObject
    {
        $className = get_called_class();
        return new $className($data);
    }

    public static function withCloningAllowed(callable $callable)
    {
        $isCloningAllowed = self::$isCloningAllowed;
        self::$isCloningAllowed = true;
        $result = $callable();
        self::$isCloningAllowed = $isCloningAllowed;
        return $result;
    }

    protected function mutateIterator($methodName, array $arguments)
    {
        self::preventMethod($methodName);
        $callable = self::$method[$methodName];
        return new DisconnectableIterator($callable($this->storage, ...$arguments));
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