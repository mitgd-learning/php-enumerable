<?php

namespace Emonkak\Enumerable\Iterator;

use Emonkak\Enumerable\EnumerableExtensions;
use Emonkak\Enumerable\EnumerableInterface;

class ConcatIterator implements \IteratorAggregate, EnumerableInterface
{
    use EnumerableExtensions;

    /**
     * @var array[]|\Traversable[]
     */
    private $sources;

    /**
     * @param array[]|\Traversable[] $sources
     */
    public function __construct(array $sources)
    {
        $this->sources = $sources;
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        foreach ($this->sources as $source) {
            foreach ($source as $element) {
                yield $element;
            }
        }
    }
}