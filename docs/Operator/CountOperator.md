# The Count operators

This operator collection is deals with counting data.


## AryO\ArrayObject::count()

Description:
````php
int \StephanSchuler\ArrayObject\ArrayObject::count()
````

This one is not an actual operator since it's no plugin but added to the basic `ArrayObject` directly to conform
with `\Countable` on one side and to be able to not return a `\Traversable` on the other.

Example code:
````php
<?PHP
use StephanSchuler\ArrayObject as AryO;

$data = AryO\ArrayObject::fromArray([1, 2, 3, 4, 5, 6])
    ->count();

print_r($data);
````

Result:
````
6
````


## AryO\ArrayObject::countValues()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::countValues()
````

Count occurrences of every given value. The result will be mapping the given value as $key to the number of
occurrences as $value.

Example code:
````php
<?PHP
use StephanSchuler\ArrayObject as AryO;

AryO\Operator\CountOperator::register();

$data = AryO\ArrayObject::fromArray(['a', 'b', 'c', 'b', 'c', 'b', 'b'])
    ->countValues();

print_r($data->getArrayCopy());
````

Result:
````
Array
(
    [a] => 1
    [b] => 4
    [c] => 2
)
````

This works by accumulating an array internally. So just like the plain PHP function `count_values()`, this only
works for scalar values for now.