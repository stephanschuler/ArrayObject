<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

class MapOperator extends AbstractOperator
{
    public static function map(array $array, callable $transformation = null, $includeKeys = false): array
    {
        if (!$transformation) {
            return $array;
        }
        if (!$includeKeys) {
            return array_map($transformation, $array);
        }
        array_walk($array, function (&$value, $key) use ($transformation) {
            $value = $transformation($value, $key);
        });
        return $array;
    }

    public static function column(array $data, $column, $indexKey = null): array
    {
        return array_column($data, $column, $indexKey);
    }

    public static function toString(array $array, $includeKeys = false): array
    {
        return self::map($array, function ($value) {
            return (string)$value;
        }, $includeKeys);
    }

    public static function toInt(array $array, $includeKeys = false): array
    {
        return self::map($array, function ($value) {
            return (int)$value;
        }, $includeKeys);
    }

    public static function toBool(array $array, $includeKeys = false): array
    {
        return self::map($array, function ($value) {
            return !!$value;
        }, $includeKeys);
    }

    public static function toCountable(array $array, $includeKeys = false): array
    {
        return self::map($array, function ($value) {
            return is_string($value) || is_numeric($value) ? $value : (string)$value;
        }, $includeKeys);
    }

    public static function negate(array $array, $includeKeys = false): array
    {
        return self::map($array, function ($value) {
            return !$value;
        }, $includeKeys);
    }
}