<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

class MapOperator extends AbstractOperator
{
    public static function map(array $data, callable $transformation = null, $includeKeys = false): array
    {
        if (!$transformation) {
            return $data;
        }
        if (!$includeKeys) {
            return array_map($transformation, $data);
        }
        array_walk($data, function (&$value, $key) use ($transformation) {
            $value = $transformation($value, $key);
        });
        return $data;
    }

    public static function column(array $data, $column, $indexKey = null): array
    {
        return array_column($data, $column, $indexKey);
    }

    public static function toString(array $data, $includeKeys = false): array
    {
        return self::map($data, function ($value) {
            return (string)$value;
        }, $includeKeys);
    }

    public static function toInt(array $data, $includeKeys = false): array
    {
        return self::map($data, function ($value) {
            return (int)$value;
        }, $includeKeys);
    }

    public static function toBool(array $data, $includeKeys = false): array
    {
        return self::map($data, function ($value) {
            return !!$value;
        }, $includeKeys);
    }

    public static function negate(array $data, $includeKeys = false): array
    {
        return self::map($data, function ($value) {
            return !$value;
        }, $includeKeys);
    }
}