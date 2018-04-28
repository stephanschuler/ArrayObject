<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

use Generator;
use Iterator;

class ChunkOperator extends AbstractOperator
{
    public static function chunk(Iterator $data, int $size): Generator
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

    public static function flat(Iterator $data): Generator
    {
        foreach ($data as $chunk) {
            foreach ($chunk as $value) {
                yield $value;
            }
        }
    }

    public static function splice(Iterator $data, int $offset, int $length = null): Generator
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

    public static function slice(Iterator $data, int $offset, int $length = null): Generator
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