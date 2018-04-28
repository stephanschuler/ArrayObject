<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

use ArrayIterator;
use Generator;
use Traversable;

class SortOperator extends AbstractOperator
{
    public static function natsort(Traversable $data): Generator
    {
        $object = new ArrayIterator(iterator_to_array($data));
        $object->natsort();
        return self::generateFromArrayIterator($object);
    }

    public static function asort(Traversable $data): Generator
    {
        $object = new ArrayIterator(iterator_to_array($data));
        $object->asort();
        return self::generateFromArrayIterator($object);
    }

    public static function ksort(Traversable $data): Generator
    {
        $object = new ArrayIterator(iterator_to_array($data));
        $object->ksort();
        return self::generateFromArrayIterator($object);
    }

    public static function uasort(Traversable $data, callable $compare): Generator
    {
        $object = new ArrayIterator(iterator_to_array($data));
        $object->uasort($compare);
        return self::generateFromArrayIterator($object);
    }

    public static function uksort(Traversable $data, callable $compare): Generator
    {
        $object = new ArrayIterator(iterator_to_array($data));
        $object->uksort($compare);
        return self::generateFromArrayIterator($object);
    }

    public static function reverse(Traversable $data): Generator
    {
        $object = new ArrayIterator(array_reverse(iterator_to_array($data)));
        return self::generateFromArrayIterator($object);
    }

    private static function generateFromArrayIterator(ArrayIterator $object): Generator
    {
        foreach ($object as $key => $value) {
            yield $key => $value;
        }
    }
}