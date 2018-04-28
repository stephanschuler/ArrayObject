<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

use Generator;
use Traversable;

class ChunkOperator extends AbstractOperator
{
    public static function chunk(Traversable $data, int $size): Generator
    {
        $chunk = [];
        foreach ($data as $key => $value) {
            if (count($chunk) === $size) {
                yield $chunk;
                $chunk = [];
            }
            $chunk[$key] = $value;
        }
        if ($chunk) {
            yield $chunk;
        }
    }

    public static function flat(Traversable $data): Generator
    {
        foreach ($data as $chunk) {
            foreach ($chunk as $value) {
                yield $value;
            }
        }
    }

    public static function splice(Traversable $data, int $offset, int $length = null): Generator
    {
        $cursor = 0;
        $max = $length ? ($offset + $length) : PHP_INT_MAX;
        foreach ($data as $key => $value) {
            if ($offset > $cursor || $cursor >= $max) {
                yield $key => $value;
            }
            $cursor++;
        }
    }

    public static function slice(Traversable $data, int $offset, int $length = null): Generator
    {
        $cursor = 0;
        $max = $length ? ($offset + $length) : PHP_INT_MAX;
        foreach ($data as $key => $value) {
            if ($offset <= $cursor && $cursor < $max) {
                yield $key => $value;
            }
            $cursor++;
        }
    }
}