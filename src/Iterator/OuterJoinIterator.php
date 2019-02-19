<?php

namespace Emonkak\Enumerable\Iterator;

use Emonkak\Enumerable\EnumerableExtensions;
use Emonkak\Enumerable\EnumerableInterface;
use Emonkak\Enumerable\Internal\Converters;
use Emonkak\Enumerable\Internal\IdentityFunction;

class OuterJoinIterator implements \IteratorAggregate, EnumerableInterface
{
    use EnumerableExtensions;

    /**
     * @var iterable
     */
    private $outer;

    /**
     * @var iterable
     */
    private $inner;

    /**
     * @var callable
     */
    private $outerKeySelector;

    /**
     * @var callable
     */
    private $innerKeySelector;

    /**
     * @var callable
     */
    private $resultSelector;

    /**
     * @param iterable $outer
     * @param iterable $inner
     * @param callable $outerKeySelector
     * @param callable $innerKeySelector
     * @param callable $resultSelector
     */
    public function __construct($outer, $inner, callable $outerKeySelector, callable $innerKeySelector, callable $resultSelector)
    {
        $this->outer = $outer;
        $this->inner = $inner;
        $this->outerKeySelector = $outerKeySelector;
        $this->innerKeySelector = $innerKeySelector;
        $this->resultSelector = $resultSelector;
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        $outerKeySelector = $this->outerKeySelector;
        $innerKeySelector = $this->innerKeySelector;
        $resultSelector = $this->resultSelector;

        $lookup = Converters::toLookup($this->inner, $innerKeySelector, [IdentityFunction::class, 'apply']);

        foreach ($this->outer as $outerElement) {
            $key = $outerKeySelector($outerElement);
            if (isset($lookup[$key])) {
                foreach ($lookup[$key] as $innerElement) {
                    yield $resultSelector($outerElement, $innerElement);
                }
            } else {
                yield $resultSelector($outerElement, null);
            }
        }
    }
}
