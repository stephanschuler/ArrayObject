# Project goals: `Traversable` over `Immutable`

Initially this lib started to as an `ArrayObject` implementation mimicking JavaScripts
`Array` object, featuring immutability and fluent interface.

The project goal shifted towards efficiently support PHPs `Traversable` like they happen
when consuming huge amounts of data. That immediately meant dropping the immutability 
since that whould mean copying the state on every operation.

# Operations as plugins

The plain `ArrayObject` has no mutating operation. There is `ArrayObect::count()` as well
as `ArrayObject::getIterator()`, but both don't change the object state. They just conform
the `Countable` and the `IteratorAggregate` for being able to iterate over the result.

Every other operation, like `ArrayObject::map()`, `ArrayObject::filter()` and many others,
comes as a plug in. That means it could in theory be swapped by different implementation or
extended by additional operations. Although I know that's pretty unlikely to happen.

## Registering a new operator

There's a public static method `ArrayObject::registerMethod()` that adds new mutation
operators to the `ArrayObject` implementation.

````php
<?PHP
use StephanSchuler\ArrayObject as AryO;

$noop = function(\Traversable $data): \Traversable
{
	foreach ($data as $key => $value) {
		yield $key => $value;
	}
};
AryO\ArrayObject::registerMethod($noop, 'noop');

$object = new AryO\ArrayObject($whateverSource);
$object->noop();

foreach ($data as $key => $value) {
	// ... whatever
}
````

This adds the new method `ArrayObject::noop()` to the existing implementation of the
`ArrayObject` to be used by every new instance.

Operator functions are meant to be pure functions. They need to accept a `Traversable` as
the very first argument (chances are that's a `Generator` but it can be an `ArrayIterator`
or any `Iterator` or `IteratorAggregate` as well) and they are required to return a
`Traversable`, too.

## The `AbstractOperator` to group operator methods

Although registering operator methods by hand can be done, that's not the way it is intended
to. Instead, there's the `AbstractOperator` class providing public static methods and a
registering method.

Define the operator:

````php
<?PHP
use StephanSchuler\Demo;
use StephanSchuler\ArrayObject as AryO;

class MyOperator extends AryO\Operator\AbstractOperator
{
	public static function noop(\Traversable $data): \Traversable
	{
		foreach ($data as $key => $value) {
			yield $key => $value;
		}
		
	}
}
````

Register and use on runtime:

````php
<?PHP
use StephanSchuler\Demo\MyOperator;
use StephanSchuler\ArrayObject as AryO;

MyOperator::register();

$data = new AryO\ArrayObject($whateverSource);
$data->noop();

foreach ($data as $key => $value) {
	// ... whatever
}
````

## Build in plugin oprators

There are a couple of operators implemented just the way explained in the last section:

````php
<?PHP
use StephanSchuler\ArrayObject as AryO;

AryO\Operator\ChunkOperator::register();
AryO\Operator\CountOperator::register();
AryO\Operator\FilterOperator::register();
AryO\Operator\FlipOperator::register();
AryO\Operator\GroupOperator::register();
AryO\Operator\IntersectOperator::register();
AryO\Operator\MapOperator::register();
AryO\Operator\ReduceOperator::register();
AryO\Operator\SortOperator::register();
````

They are provide several methods each explained in individual documentation files.

# Stubs for IDE integration

Have a look at the folder [stubs/Operator](../../master/stubs/Operator). For every build
in Operator class there is a file named alike containing **a new class definition for
ArrayObject**. They are not meant to be loaded ever because that would conflict with the
original `ArrayObject` class definition. But thes do help IDEs like PHPStorm to auto
complete and type hint for every method available. 
