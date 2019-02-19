<?php

namespace Emonkak\Enumerable;

use Emonkak\Enumerable\Internal\Errors;
use Emonkak\Enumerable\Iterator\ConcatIterator;
use Emonkak\Enumerable\Iterator\DeferIterator;
use Emonkak\Enumerable\Iterator\EmptyIterator;
use Emonkak\Enumerable\Iterator\GenerateIterator;
use Emonkak\Enumerable\Iterator\IfIterator;
use Emonkak\Enumerable\Iterator\OnErrorResumeNextIterator;
use Emonkak\Enumerable\Iterator\RangeIterator;
use Emonkak\Enumerable\Iterator\StaticCatchIterator;
use Emonkak\Enumerable\Iterator\StaticRepeatIterator;
use Emonkak\Enumerable\Iterator\ZipIterator;

final class Enumerable
{
    /**
     * @param iterable $source
     * @return EnumerableInterface
     */
    public static function from($source)
    {
        if (!(is_array($source) || $source instanceof \Traversable)) {
            $type = gettype($source);
            $typeOrClass = ($type === 'object' ? get_class($source) : $type);
            throw new \RuntimeException("The source must be an array or traversable object, got '$typeOrClass'");
        }
        return new Sequence($source);
    }

    /**
     * @param iterable[] ...$sources
     * @return EnumerableInterface
     */
    public static function _catch(...$sources)
    {
        return new StaticCatchIterator($sources);
    }

    /**
     * @param iterable[] ...$sources
     * @return EnumerableInterface
     */
    public static function concat(...$sources)
    {
        return new ConcatIterator($sources);
    }

    /**
     * @param callable $traversableFactory
     * @return EnumerableInterface
     */
    public static function defer(callable $traversableFactory)
    {
        return new DeferIterator($traversableFactory);
    }

    /**
     * @param mixed $initialState
     * @param callable $condition
     * @param callable $iterate
     * @param callable $resultSelector
     * @return EnumerableInterface
     */
    public static function generate($initialState, callable $condition, callable $iterate, callable $resultSelector)
    {
        return new GenerateIterator($initialState, $condition, $iterate, $resultSelector);
    }

    /**
     * @param callable $condition
     * @param iterable $thenSource
     * @param iterable $elseSource
     * @return EnumerableInterface
     */
    public static function _if(callable $condition, $thenSource, $elseSource)
    {
        return new IfIterator($condition, $thenSource, $elseSource);
    }

    /**
     * @param iterable[] ...$sources
     * @return EnumerableInterface
     */
    public static function onErrorResumeNext(...$sources)
    {
        return new OnErrorResumeNextIterator($sources);
    }

    /**
     * @param int $start
     * @param int $count
     * @return EnumerableInterface
     */
    public static function range($start, $count)
    {
        return new RangeIterator($start, $count);
    }

    /**
     * @param mixed $element
     * @param int $count
     * @return EnumerableInterface
     */
    public static function repeat($element, $count = null)
    {
        if ($count < 0) {
            throw Errors::argumentOutOfRange('count');
        }
        return new StaticRepeatIterator($element, $count);
    }

    /**
     * @param mixed $element
     * @return EnumerableInterface
     */
    public static function _return($element)
    {
        return new Sequence([$element]);
    }

    /**
     * @param iterable $first
     * @param iterable $second
     * @return EnumerableInterface
     */
    public static function zip($first, $second, callable $resultSelector)
    {
        return new ZipIterator($first, $second, $resultSelector);
    }

    /**
     * @return EnumerableInterface
     */
    public static function _empty()
    {
        return new EmptyIterator();
    }

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }
}
