<?php

declare(strict_types=1);

namespace Emonkak\Enumerable;

/**
 * @template TKey
 * @template TValue
 */
class Dictionary implements \IteratorAggregate, EnumerableInterface
{
    use EnumerableExtensions;

    const KEY = 0;
    const VALUE = 1;

    /**
     * @var EqualityComparerInterface<TKey>
     */
    private $comparer;

    /**
     * @var array{0:TKey,1:TValue}[]
     */
    private $hashTable = [];

    /**
     * @template TKey
     * @template TValue
     * @return self<TKey,TValue>
     */
    public static function create(): self
    {
        return new self(EqualityComparer::getInstance());
    }

    /**
     * @suppress PhanGenericConstructorTypes
     * @param EqualityComparerInterface<TKey> $comparer
     */
    public function __construct(EqualityComparerInterface $comparer)
    {
        $this->comparer = $comparer;
    }

    public function getIterator(): \Traversable
    {
        foreach ($this->hashTable as $entry) {
            yield $entry;
        }
    }

    /**
     * @return iterable<array{0:TKey,1:TValue}>
     */
    public function getSource(): iterable
    {
        return $this->hashTable;
    }

    /**
     * @param TKey $key
     * @param TValue $value
     */
    public function set($key, $value): bool
    {
        $hash = $this->comparer->hash($key);
        if (array_key_exists($hash, $this->hashTable)) {
            if (!$this->comparer->equals($key, $this->hashTable[$hash][self::KEY])) {
                $other = $this->hashTable[$hash][self::KEY];
                throw new \RuntimeException(sprintf(
                    'Hash collision detected, between "%s" and "%s"',
                    gettype($value),
                    gettype($other)
                ));
            }
            return false;
        }
        $this->hashTable[$hash] = [$key, $value];
        return true;
    }

    /**
     * @param TKey $key
     */
    public function has($key): bool
    {
        $hash = $this->comparer->hash($key);
        return array_key_exists($hash, $this->hashTable);
    }

    /**
     * @param TKey $key
     * @param TValue &$value
     * @return bool
     */
    public function tryGet($key, &$value): bool
    {
        $hash = $this->comparer->hash($key);
        if (!array_key_exists($hash, $this->hashTable)) {
            return false;
        }
        $value = $this->hashTable[$hash][self::VALUE];
        return true;
    }

    /**
     * @param TKey $key
     */
    public function remove($key): bool
    {
        $hash = $this->comparer->hash($key);
        if (!array_key_exists($hash, $this->hashTable)) {
            return false;
        }
        unset($this->hashTable[$hash]);
        return true;
    }

    /**
     * @return array{0:TKey,1:TValue}[]
     */
    public function toArray(): array
    {
        return array_values($this->hashTable);
    }
}
