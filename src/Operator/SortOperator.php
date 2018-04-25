<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

class SortOperator extends AbstractOperator
{
    public static function natsort(array $data): array
    {
        natsort($data);
        return $data;
    }

    public static function sort(array $data): array
    {
        sort($data);
        return $data;
    }

    public static function asort(array $data): array
    {
        asort($data);
        return $data;
    }

    public static function uasort(array $data, callable $compare): array
    {
        uasort($data, $compare);
        return $data;
    }

    public static function usort(array $data, callable $compare): array
    {
        usort($data, $compare);
        return $data;
    }

    public static function reverse(array $array): array
    {
        return array_reverse($array);
    }
}