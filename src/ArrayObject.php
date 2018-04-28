<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject;

use Countable;
use Generator;
use Iterator;
use IteratorAggregate;

class ArrayObject implements IteratorAggregate, Countable
{
    /**
     * @var callable[]
     */
    private static $method = [];

    /**
     * @var Iterator[]
     */
    private static $storage;

    /**
     * @var string
     */
    private $storageIdentifier;

    /**
     * @var bool
     */
    private $connected = true;

    /**
     * @var int
     */
    private static $instanceCount = 0;

    public function __construct(Iterator $data)
    {
        $this->storageIdentifier = $this->generateStorageIdentifier();
        self::$storage[$this->storageIdentifier] = $data;
    }

    public function __destruct()
    {
        unset(self::$storage[$this->storageIdentifier]);
    }

    public function __call(string $methodName, array $arguments)
    {
        if ($this->connected) {
            self::$storage[$this->storageIdentifier] = $this->mutateIterator($methodName, $arguments);
            return $this;
        } else {
            $className = get_called_class();
            return new $className($this->mutateIterator($methodName, $arguments));
        }
    }

    public function __clone()
    {
        $source = self::$storage[$this->storageIdentifier];

        $target1 = self::$storage[$this->storageIdentifier] = new \ArrayIterator();
        $this->storageIdentifier = $this->generateStorageIdentifier();
        $target2 = self::$storage[$this->storageIdentifier] = new \ArrayIterator();

        foreach ($source as $key => $value) {
            $target1[$key] = $value;
            $target2[$key] = $value;
        }
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
        foreach (self::$storage[$this->storageIdentifier] as $key => $value) {
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

    protected function mutateIterator($methodName, array $arguments)
    {
        self::preventMethod($methodName);
        $callable = self::$method[$methodName];
        return $callable(self::$storage[$this->storageIdentifier], ...$arguments);
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

    private function generateStorageIdentifier()
    {
        return self::$instanceCount++;
    }
}