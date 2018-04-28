<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

use Generator;
use Iterator;

class MapOperator extends AbstractOperator
{
    public static function map(Iterator $data, callable $transform): Generator
    {
        foreach ($data as $key => $value) {
            yield $key => $transform($value);
        }
    }

    public static function column(Iterator $data, $column, $indexKey = null): Generator
    {
        foreach ($data as $key => $value) {
            yield (is_null($indexKey) ? $key : $value[$indexKey]) => $value[$column];
        }
    }

    public static function toString(Iterator $data): Generator
    {

        return self::map($data, function ($value) {
            return (string)$value;
        });
    }

    public static function toInt(Iterator $data): Generator
    {
        return self::map($data, function ($value) {
            return (int)$value;
        });
    }

    public static function toBool(Iterator $data): Generator
    {
        return self::map($data, function ($value) {
            return !!$value;
        });
    }

    public static function negate(Iterator $data): Generator
    {
        return self::map($data, function ($value) {
            return !$value;
        });
    }
}