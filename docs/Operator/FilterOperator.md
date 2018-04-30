# The Filter operators

This operator collection is deals with filtering data.


## AryO\ArrayObject::filter()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::filter(callable $compare = null)
````

If an element of the input data makes the compare function return true it is added to the result set, otherwise
it's skipped.

Example code:
````php
<?PHP
use StephanSchuler\ArrayObject as AryO;

AryO\Operator\FilterOperator::register();

$data = AryO\ArrayObject::fromArray([1, 2, 3, 4, 5, 6])
    ->filter(function ($element) {
        return $element % 2;
    });

print_r($data->getArrayCopy());
````

Result:
````
Array
(
    [0] => 1
    [2] => 3
    [4] => 5
)
````

Keys are left intact.


## AryO\ArrayObject::distinctUntilChanged()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::distinctUntilChanged(callable $compare = null)
````

An incoming value is omitted that matches the previous one. So this is not a truly `unique` mechanism since it
only looks one element behind. But in case the input data is ordered accordingly it might be close enough.

Example code:
````php
<?PHP
use StephanSchuler\ArrayObject as AryO;

AryO\Operator\FilterOperator::register();

$data = AryO\ArrayObject::fromArray(['a', 'b', 'b', 'b', 'c', 'b', 'b'])
    ->distinctUntilChanged();

print_r($data->getArrayCopy());
````

Result:
````
Array
(
    [0] => a
    [1] => b
    [4] => c
    [5] => b
)
````

An additional compare function allows to discriminator value, so distinctUntilChanged also works on objects or for
comparing properties of each element.

Example code:
````php
<?PHP
use StephanSchuler\ArrayObject as AryO;

AryO\Operator\FilterOperator::register();

$data = AryO\ArrayObject::fromArray([
        ['name' => 'a', 'id' => 0],
        ['name' => 'b', 'id' => 1],
        ['name' => 'b', 'id' => 2],
        ['name' => 'b', 'id' => 3],
        ['name' => 'c', 'id' => 4],
        ['name' => 'b', 'id' => 5],
        ['name' => 'b', 'id' => 6]
    ])
    ->distinctUntilChanged(function ($element) {
        return $element['name'];
    });

print_r($data->getArrayCopy());
````

Result:
````
Array
(
    [0] => Array
        (
            [name] => a
            [id] => 0
        )

    [1] => Array
        (
            [name] => b
            [id] => 1
        )

    [4] => Array
        (
            [name] => c
            [id] => 4
        )

    [5] => Array
        (
            [name] => b
            [id] => 5
        )
)
````

Keys are left intact.