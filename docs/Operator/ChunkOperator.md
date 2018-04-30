# The Chunk operators

This operator collection is deals with chunks or slices of the data set.


## AryO\ArrayObject::chunk()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::chunk(int $size)
````

The actual chunk method creates chunks of equal size and emmits not for every item
but for every chunk.

Example code:
````php
<?PHP
use StephanSchuler\ArrayObject as AryO;

AryO\Operator\CountOperator::ChunkOperator();

$data = AryO\ArrayObject::fromArray([1, 2, 3, 4, 5, 6])
    ->chunk(2);

print_r($data->getArrayCopy());
````

Result:
````
Array
(
    [0] => Array
        (
            [0] => 1
            [1] => 2
        )

    [1] => Array
        (
            [2] => 3
            [3] => 4
        )

    [2] => Array
        (
            [4] => 5
            [5] => 6
        )

)
````

As shown, the chunk keys are named consecutively, but the keys inside of each chunk are left intact.


## AryO\ArrayObject::flat()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::flat()
````

Flattening is the reverse operation of chunking.

Example code:
````php
<?PHP
use StephanSchuler\ArrayObject as AryO;

AryO\Operator\CountOperator::ChunkOperator();

$data = AryO\ArrayObject::fromArray([[1, 2], [3, 4], [5, 6]])
    ->flat();

print_r($data->getArrayCopy());
````

Result:
````
Array
(
    [0] => 1
    [1] => 2
    [2] => 3
    [3] => 4
    [4] => 5
    [5] => 6
)
````

Keys are assigned consecutively.


## ArrayObject::splice()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::splice(int $offset, int $length = null)
````

Picture: Cut the section "from offset with given length" out of the input data and splice both ends togeterh again.

Technically: Filter by keeping only elements that are either before the starting offset or after the end.

Example:
````php
<?PHP
use StephanSchuler\ArrayObject as AryO;

AryO\Operator\CountOperator::ChunkOperator();

$data = AryO\ArrayObject::fromArray(['a', 'b', 'c', 'd', 'e', 'f'])
	->splice(3, 2);

print_r($data->getArrayCopy());
````

Result:
````
Array
(
    [0] => a
    [1] => b
    [2] => c
    [5] => f
)
````

Keys are left intact.


## ArrayObject::slice()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::slice(int $offset, int $length = null)
````

Instead of dropping the defined section like splice does and keeping the remaining left and right side of the data,
splice drops the left and the right side and only keeps the data between the given offset and length.

Example:
````php
<?PHP
use StephanSchuler\ArrayObject as AryO;

AryO\Operator\CountOperator::ChunkOperator();

$data = AryO\ArrayObject::fromArray(['a', 'b', 'c', 'd', 'e', 'f'])
	->slice(3, 2);

print_r($data->getArrayCopy());
````

Result:
````
Array
(
    [3] => 'd'
    [4] => 'e'
)
````

Keys are left intact.