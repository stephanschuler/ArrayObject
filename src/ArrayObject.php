<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject;

use Countable;
use Generator;
use Iterator;
use IteratorAggregate;

class ArrayObject implements IteratorAggregate, Countable
{
    private static $method = [];

    /**
     * @var Iterator
     */
    private static $storage;

    /**
     * @var string
     */
    private $storageIdentifier;

    /**
     * @var int
     */
    private static $instanceCount = 0;

    public function __construct(Iterator $data = null)
    {
        $this->storageIdentifier = $this->generateStorageIdentifier();
        self::$storage[$this->storageIdentifier] = $data;
    }

    public function __destruct()
    {
        unset(self::$storage[$this->storageIdentifier]);
    }

    public function getIterator(): Generator
    {
        (self::$storage[$this->storageIdentifier] instanceof Generator) && clone $this;
        foreach (self::$storage[$this->storageIdentifier] as $key => $value) {
            yield $key => $value;
        }
    }

    public function __call(string $methodName, array $arguments)
    {
        self::preventMethod($methodName);
        $callable = self::$method[$methodName];

        self::$storage[$this->storageIdentifier] = $callable(self::$storage[$this->storageIdentifier], ...$arguments);
        return $this;
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

    private function generateStorageIdentifier()
    {
        return self::$instanceCount++;
    }
}