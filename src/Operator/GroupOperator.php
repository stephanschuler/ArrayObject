<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

use Generator;
use Traversable;

class GroupOperator extends AbstractOperator implements OperatorInterface
{
    public static function groupSubsequent(Traversable $data, callable $compare, int $groupSize): Generator
    {
        $lastGroupDiscriminator = null;
        $group = [];
        foreach ($data as $key => $value) {
            $discriminator = $compare($value);
            if ($discriminator !== $lastGroupDiscriminator) {
                if (count($group)) {
                    yield $lastGroupDiscriminator => $group;
                }
                $group = [];
            }
            if (count($group) <= $groupSize) {
                $group[$key] = $value;
            }
            $lastGroupDiscriminator = $discriminator;
        }
        if (count($group)) {
            yield $lastGroupDiscriminator => $group;
        }
    }

    public static function groupBatch(
        Traversable $data,
        callable $compare,
        int $groupSize,
        int $numberOfGroups = PHP_INT_MAX
    ): Generator {
        $groups = [];
        foreach ($data as $key => $value) {
            $discriminator = $compare($value);
            if (!isset($groups[$discriminator])) {
                if (count($groups) >= $numberOfGroups) {
                    break;
                }
                $groups[$discriminator] = [];
            }
            if (count($groups[$discriminator]) < $groupSize) {
                $groups[$discriminator][$key] = $value;
            }
        }
        yield from $groups;
    }
}