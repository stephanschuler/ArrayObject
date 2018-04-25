<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

use StephanSchuler\ArrayObject\ArrayObject;

/**
 * An Operator is a set of methods all callable at any instance of the
 * ArrayObject. Result of every method is a new ArrayObject instance, so
 * operator chaining in fluent interfaces is intended.
 *
 * @package StephanSchuler\ArrayObject
 */
abstract class AbstractOperator
{
    /**
     * Operators are not meant to be created, they just act as collections
     * of pure functions in a distinct namespace.
     */
    protected function __construct()
    {
    }

    /**
     * Makes a certain Operator known to the ArrayObject in order to have
     * all the Operators methods being available as operator methods.
     *
     * @throws \Exception
     */
    public static function register()
    {
        $className = get_called_class();
        $methodNames = array_diff(
            get_class_methods(get_called_class()),
            get_class_methods(AbstractOperator::class)
        );
        array_map(function ($methodName) use ($className) {
            ArrayObject::registerMethod($className, $methodName);
        }, $methodNames);
    }
}