# The Reduce operators


## AryO\ArrayObject::reduce()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::reduce(callable $transform = null, $initial = null)
````

This resembles the array_reduce() function: Starting with a given `$initial`, every element of the `\Traversable`
is added up to create the result.

Example code:
````php
AryO\Operator\ReduceOperator::register();

$data = AryO\ArrayObject::fromArray([1, 2, 3, 4, 5, 6, 7])
    ->reduce(function($carry, $value) {
        return $carry * 2 + $value;
    }, 0);

print_r($data->getArrayCopy());
````

Result:
````
Array
(
    [0] => 247
)
````