<?php

declare(strict_types=1);

namespace Emonkak\Enumerable\Tests;

use Emonkak\Enumerable\EqualityComparerInterface;
use Emonkak\Enumerable\Set;
use PHPUnit\Framework\TestCase;

/**
 * @covers Emonkak\Enumerable\Set
 */
class SetTest extends TestCase
{
    public function testAdd()
    {
        $longString = str_repeat('abracadabra', 100);

        $set = Set::create();

        $this->assertTrue($set->add('foo'));
        $this->assertFalse($set->add('foo'));
        $this->assertTrue($set->add('123'));
        $this->assertFalse($set->add('123'));
        $this->assertTrue($set->add(123));
        $this->assertFalse($set->add(123));
        $this->assertTrue($set->add(123.0));
        $this->assertFalse($set->add(123.0));
        $this->assertTrue($set->add(true));
        $this->assertFalse($set->add(true));
        $this->assertTrue($set->add(false));
        $this->assertFalse($set->add(false));
        $this->assertTrue($set->add(null));
        $this->assertFalse($set->add(null));
        $this->assertTrue($set->add(new \stdClass()));
        $this->assertFalse($set->add(new \stdClass()));
        $this->assertTrue($set->add(['foo' => 'bar']));
        $this->assertFalse($set->add(['foo' => 'bar']));
        $this->assertTrue($set->add($longString));
        $this->assertFalse($set->add($longString));

        $this->assertEquals(['foo', '123', 123, 123.0, true, false, null, new \stdClass(), ['foo' => 'bar'], $longString], iterator_to_array($set));
    }

    /**
     * @expectedException RuntimeException
     */
    public function testAddWithHashCollision()
    {
        $comparer = $this->createMock(EqualityComparerInterface::class);
        $comparer
            ->expects($this->any())
            ->method('hash')
            ->willReturn(0);
        $comparer
            ->expects($this->any())
            ->method('equals')
            ->will($this->returnCallback(function($first, $second) {
                return $first === $second;
            }));

        $set = new Set($comparer);
        $set->add('foo');
        $set->add('bar');
    }

    public function testRemove()
    {
        $longString = str_repeat('abracadabra', 100);

        $set = Set::create();

        $set->addAll(['foo', '123', 123, 123.0, true, null, new \stdClass(), new \stdClass(), ['foo' => 'bar'], $longString]);

        $this->assertTrue($set->remove('foo'));
        $this->assertFalse($set->remove('foo'));
        $this->assertEquals(['123', 123, 123.0, true, null, new \stdClass(), ['foo' => 'bar'], $longString], iterator_to_array($set));

        $this->assertTrue($set->remove('123'));
        $this->assertFalse($set->remove('123'));
        $this->assertEquals([123, 123.0, true, null, new \stdClass(), ['foo' => 'bar'], $longString], iterator_to_array($set));

        $this->assertTrue($set->remove(123));
        $this->assertFalse($set->remove(123));
        $this->assertEquals([123.0, true, null, new \stdClass(), ['foo' => 'bar'], $longString], iterator_to_array($set));

        $this->assertTrue($set->remove(123.0));
        $this->assertFalse($set->remove(123.0));
        $this->assertEquals([true, null, new \stdClass(), ['foo' => 'bar'], $longString], iterator_to_array($set));

        $this->assertTrue($set->remove(true));
        $this->assertFalse($set->remove(true));
        $this->assertEquals([null, new \stdClass(), ['foo' => 'bar'], $longString], iterator_to_array($set));

        $this->assertTrue($set->remove(null));
        $this->assertFalse($set->remove(null));
        $this->assertEquals([new \stdClass(), ['foo' => 'bar'], $longString], iterator_to_array($set));

        $this->assertTrue($set->remove(new \stdClass()));
        $this->assertFalse($set->remove(new \stdClass()));
        $this->assertEquals([['foo' => 'bar'], $longString], iterator_to_array($set));

        $this->assertTrue($set->remove(['foo' => 'bar']));
        $this->assertFalse($set->remove(['foo' => 'bar']));
        $this->assertEquals([$longString], iterator_to_array($set));

        $this->assertTrue($set->remove($longString));
        $this->assertFalse($set->remove($longString));
        $this->assertEquals([], iterator_to_array($set));
    }
}
