<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

class ChunkOperator extends AbstractOperator
{
    public static function chunk(array $data, int $size, $preserveKeys = true): array
    {
        return array_chunk($data, $size, $preserveKeys);
    }

    public static function flat(array $data): array
    {
        return array_merge(...$data);
    }

    public static function splice(array $data, int $offset, int $length = null): array
    {
        array_splice($data, $offset, $length);
        return $data;
    }

    public static function slice(array $data, int $offset, int $length = null, $preserveKeys = false): array
    {
        return array_slice($data, $offset, $length, $preserveKeys);
    }
}