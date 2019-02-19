<?php

namespace Emonkak\Enumerable;

interface EnumerableInterface extends \Traversable
{
    /**
     * @param mixed $seed
     * @param callable $func
     * @return mixed
     */
    public function aggregate($seed, callable $func);

    /**
     * @param ?callable $predicate
     * @return bool
     */
    public function all(callable $predicate = null);

    /**
     * @param ?callable $predicate
     * @return bool
     */
    public function any(callable $predicate = null);

    /**
     * @param ?callable $selector
     * @return bool
     */
    public function average(callable $selector = null);

    /**
     * @param int $count
     * @param ?int $skip
     * @return EnumerableInterface
     */
    public function buffer($count, $skip = null);

    /**
     * @param callable $handler
     * @return EnumerableInterface
     */
    public function _catch(callable $handler);

    /**
     * @param iterable $second
     * @return EnumerableInterface
     */
    public function concat($second);

    /**
     * @param callable $predicate
     * @return int
     */
    public function count(callable $predicate = null);

    /**
     * @param mixed $defaultValue
     * @return EnumerableInterface
     */
    public function defaultIfEmpty($defaultValue);

    /**
     * @param ?callable $keySelector
     * @param ?EqualityComparerInterface $comparer
     * @return EnumerableInterface
     */
    public function distinct(callable $keySelector = null, EqualityComparerInterface $comparer = null);

    /**
     * @param ?callable $keySelector
     * @return EnumerableInterface
     */
    public function distinctUntilChanged(callable $keySelector = null);

    /**
     * @param callable $action
     * @return EnumerableInterface
     */
    public function _do(callable $action);

    /**
     * @param callable $condition
     * @return EnumerableInterface
     */
    public function doWhile(callable $condition);

    /**
     * @param int $index
     * @return mixed
     */
    public function elementAt($index);

    /**
     * @param int $index
     * @param mixed $defaultValue
     * @return mixed
     */
    public function elementAtOrDefault($index, $defaultValue = null);

    /**
     * @param iterable $second
     * @param ?EqualityComparerInterface $comparer
     * @return EnumerableInterface
     */
    public function except($second, EqualityComparerInterface $comparer = null);

    /**
     * @param callable $finallyAction
     * @return EnumerableInterface
     */
    public function _finally(callable $finallyAction);

    /**
     * @param ?callable $predicate
     * @return mixed
     */
    public function first(callable $predicate = null);

    /**
     * @param ?callable $predicate
     * @param mixed $defaultValue
     * @return mixed
     */
    public function firstOrDefault(callable $predicate = null, $defaultValue = null);

    /**
     * @param ?callable $action
     */
    public function _forEach(callable $action);

    /**
     * @param callable $keySelector
     * @param callable $elementSelector
     * @param callable $resultSelector
     * @return EnumerableInterface
     */
    public function groupBy(callable $keySelector, callable $elementSelector = null, callable $resultSelector = null);

    /**
     * @param iterable $inner
     * @param callable $outerKeySelector
     * @param callable $innerKeySelector
     * @param callable $resultSelector
     * @return EnumerableInterface
     */
    public function groupJoin($inner, callable $outerKeySelector, callable $innerKeySelector, callable $resultSelector);

    /**
     * @return EnumerableInterface
     */
    public function ignoreElements();

    /**
     * @param iterable $second
     * @param ?EqualityComparerInterface $comparer
     * @return EnumerableInterface
     */
    public function intersect($second, EqualityComparerInterface $comparer = null);

    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @param iterable $inner
     * @param callable $outerKeySelector
     * @param callable $innerKeySelector
     * @param callable $resultSelector
     * @return EnumerableInterface
     */
    public function join($inner, callable $outerKeySelector, callable $innerKeySelector, callable $resultSelector);

    /**
     * @param ?callable $predicate
     * @return mixed
     */
    public function last(callable $predicate = null);

    /**
     * @param ?callable $predicate
     * @param mixed $defaultValue
     * @return mixed
     */
    public function lastOrDefault(callable $predicate = null, $defaultValue = null);

    /**
     * @param ?callable $selector
     * @return int
     */
    public function max(callable $selector = null);

    /**
     * @param callable $selector
     * @return mixed[]
     */
    public function maxBy(callable $keySelector);

    /**
     * @return EnumerableInterface
     */
    public function memoize();

    /**
     * @param ?callable $selector
     * @return int
     */
    public function min(callable $selector = null);

    /**
     * @param callable $selector
     * @return mixed[]
     */
    public function minBy(callable $keySelector);

    /**
     * @param iterable[] $sources
     * @return EnumerableInterface
     */
    public function onErrorResumeNext($second);

    /**
     * @param iterable $inner
     * @param callable $outerKeySelector
     * @param callable $innerKeySelector
     * @param callable $resultSelector
     * @return EnumerableInterface
     */
    public function outerJoin($inner, callable $outerKeySelector, callable $innerKeySelector, callable $resultSelector);

    /**
     * @param ?callable $keySelector
     * @return OrderedEnumerableInterface
     */
    public function orderBy(callable $keySelector = null);

    /**
     * @param ?callable $keySelector
     * @return OrderedEnumerableInterface
     */
    public function orderByDescending(callable $keySelector = null);

    /**
     * @param ?int $count
     * @return EnumerableInterface
     */
    public function repeat($count = null);

    /**
     * @param ?int $retryCount
     * @return EnumerableInterface
     */
    public function retry($retryCount = null);

    /**
     * @return EnumerableInterface
     */
    public function reverse();

    /**
     * @param mixed $seed
     * @param callable $func
     * @return mixed
     */
    public function scan($seed, callable $func);

    /**
     * @param callable $selector
     * @return EnumerableInterface
     */
    public function select(callable $selector);

    /**
     * @param callable $collectionSelector
     * @return EnumerableInterface
     */
    public function selectMany(callable $collectionSelector);

    /**
     * @param ?callable $predicate
     * @return mixed
     */
    public function single(callable $predicate = null);

    /**
     * @param ?callable $predicate
     * @return mixed
     */
    public function singleOrDefault(callable $predicate = null, $defaultValue = null);

    /**
     * @param int $count
     * @return EnumerableInterface
     */
    public function skip($count);

    /**
     * @param int $count
     * @return EnumerableInterface
     */
    public function skipLast($count);

    /**
     * @param callable $predicate
     * @return EnumerableInterface
     */
    public function skipWhile(callable $predicate);

    /**
     * @param mixed[] ...$elements
     * @return EnumerableInterface
     */
    public function startWith(...$elements);

    /**
     * @param ?callable $selector
     * @return int
     */
    public function sum(callable $selector = null);

    /**
     * @param int $count
     * @return EnumerableInterface
     */
    public function take($count);

    /**
     * @param int $count
     * @return EnumerableInterface
     */
    public function takeLast($count);

    /**
     * @param callable $predicate
     * @return EnumerableInterface
     */
    public function takeWhile(callable $predicate);

    /**
     * @return mixed[]
     */
    public function toArray();

    /**
     * @param callable $keySelector
     * @param ?callable $elementSelector
     * @return array
     */
    public function toDictionary(callable $keySelector, callable $elementSelector = null);

    /**
     * @param callable $keySelector
     * @param ?callable $elementSelector
     * @return array
     */
    public function toLookup(callable $keySelector, callable $elementSelector = null);

    /**
     * @return \Iterator
     */
    public function toIterator();

    /**
     * @param iterable $second
     * @param ?EqualityComparerInterface $comparer
     * @return EnumerableInterface
     */
    public function union($second, EqualityComparerInterface $comparer = null);

    /**
     * @param callable $predicate
     * @return EnumerableInterface
     */
    public function where(callable $predicate);

    /**
     * @param callable $condition
     * @return EnumerableInterface
     */
    public function _while(callable $condition);

    /**
     * @param iterable $second
     * @param callable $resultSelector
     * @return EnumerableInterface
     */
    public function zip($second, callable $resultSelector);
}
