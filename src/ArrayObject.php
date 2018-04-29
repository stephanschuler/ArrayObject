<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject;

use Countable;
use Generator;
use IteratorAggregate;
use StephanSchuler\ArrayObject\Exception\CloningDisabledException;
use StephanSchuler\ArrayObject\Exception\RedeclareMethodException;
use StephanSchuler\ArrayObject\Exception\UndefinedMethodCallException;
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

    /**
     * Create a new ArrayObject
     *
     * @param Traversable $data
     */
    public function __construct(Traversable $data)
    {
        $this->storage = new DisconnectableIterator($data);
    }

    /**
     * All operator methods are plugins.
     *
     * @param string $methodName
     * @param array $arguments
     * @return $this
     */
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

    /**
     * Cloning means unwrapping the storage Traversable. Avoid if possible.
     *
     * @throws CloningDisabledException
     */
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

    /**
     * Connected ArrayObjects return $this and manipulate internal state when calling an operator.
     *
     * @return ArrayObject $this
     */
    public function connect()
    {
        $this->connected = true;
        return $this;
    }

    /**
     * Disconnected ArrayObjects return new objects when calling an operator, the state of the
     * source stays unchanged.
     *
     * @return ArrayObject
     */
    public function disconnect()
    {
        $this->connected = false;
        return clone $this;
    }

    /**
     * All operators are meant to take Traversables and return Traversables. Since self::count()
     * needs to return an integer, implementing it as plugin is not an option.
     * Additionally, ArrayObject does implement the Countable interface which requires
     * self::count() to be an actual method.
     *
     * @return int
     */
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

    /**
     * Required by the IteratorAggregate interface.
     *
     * @return Generator
     */
    public function getIterator(): Generator
    {
        foreach ($this->storage as $key => $value) {
            yield $key => $value;
        }
    }

    /**
     * This immediately unwraps the internal state!
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return iterator_to_array($this->getIterator());
    }

    /**
     * The callable is registered as new method for every ArrayObject.
     *
     * @param callable $method
     * @param string $methodName
     * @throws RedeclareMethodException
     */
    public static function registerMethod(callable $method, string $methodName)
    {
        if (isset(self::$method[$methodName])) {
            throw new RedeclareMethodException(sprintf(
                'Cannot redeclare %s::%s().',
                get_called_class(),
                $methodName
            ), 1525011658);
        }
        self::$method[$methodName] = $method;
    }

    /**
     * Static factory shorthand for creating ArrayObjects from arrays
     *
     * @param array $data
     * @return ArrayObject
     */
    public static function fromArray(array $data): ArrayObject
    {
        return self::fromIterator(new \ArrayIterator($data));
    }

    /**
     * Static factory shorthand for creating ArrayObjects from Traversables
     *
     * @param array $data
     * @return ArrayObject
     */

    public static function fromIterator(Traversable $data): ArrayObject
    {
        $className = get_called_class();
        return new $className($data);
    }

    /**
     * Execute the given callable while temporarily enable cloning of ArrayObjects. This
     * is meant to make sure no accidental unwrapping is done resulting in unintended
     * memory consumption.
     *
     * @param callable $callable
     * @return mixed
     */
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
            throw new UndefinedMethodCallException(sprintf(
                'Call to undefined method %s::%s()".',
                get_called_class(),
                $methodName
            ), 1524688036);
        }
    }
}