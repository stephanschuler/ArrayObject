<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

use Generator;
use Traversable;

class MapOperator extends AbstractOperator
{
    public static function map(Traversable $data, callable $transform): Generator
    {
        foreach ($data as $key => $value) {
            yield $key => $transform($value);
        }
    }

    public static function column(Traversable $data, $column, $indexKey = null): Generator
    {
        foreach ($data as $key => $value) {
            yield (is_null($indexKey) ? $key : $value[$indexKey]) => $value[$column];
        }
    }

    public static function toString(Traversable $data): Generator
    {

        return self::map($data, function ($value) {
            return (string)$value;
        });
    }

    public static function toInt(Traversable $data): Generator
    {
        return self::map($data, function ($value) {
            return (int)$value;
        });
    }

    public static function toBool(Traversable $data): Generator
    {
        return self::map($data, function ($value) {
            return !!$value;
        });
    }

    public static function negate(Traversable $data): Generator
    {
        return self::map($data, function ($value) {
            return !$value;
        });
    }
}