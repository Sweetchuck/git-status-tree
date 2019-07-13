<?php

declare(strict_types = 1);

namespace Sweetchuck\GitStatusTree\Tests\Unit;

use Codeception\Test\Unit;
use PHPUnit\Framework\Assert;
use Sweetchuck\GitStatusTree\Entry;
use Sweetchuck\GitStatusTree\EntryComparer;

/**
 * @covers \Sweetchuck\GitStatusTree\EntryComparer
 */
class EntityComparerTest extends Unit
{
    public function casesCompare(): array
    {
        $cases = [];

        $a = new Entry();
        $a->status = 'A';

        $b = new Entry();
        $b->status = 'AM';
        $cases['order default, status -1, type eq, name eq'] = [0, $a, $b];

        $a = new Entry();
        $a->name = 'a';

        $b = new Entry();
        $b->name = 'b';
        $cases['order default, status eq, type eq, name -1'] = [-1, $a, $b];

        $a = new Entry();
        $a->type = 'dir';
        $a->name = 'b';

        $b = new Entry();
        $b->type = 'file';
        $b->name = 'a';
        $cases['order default, status eq, type -1, name +1'] = [-1, $a, $b];

        $a = new Entry();
        $a->name = 'a';
        $a->type = 'file';

        $b = new Entry();
        $b->name = 'a';
        $b->type = 'dir';
        $cases['order default, status eq, type +1, name eq'] = [1, $a, $b];

        $a = new Entry();
        $a->status = 'A';
        $a->type = 'dir';
        $a->name = 'a';

        $b = new Entry();
        $b->status = 'A';
        $b->type = 'dir';
        $b->name = 'a';
        $cases['order status-type, status eq, type eq, name eq'] = [0, $a, $b, ['status', 'type']];

        $a = new Entry();
        $a->status = 'A';
        $a->type = 'dir';
        $a->name = 'a';

        $b = new Entry();
        $b->status = 'A';
        $b->type = 'dir';
        $b->name = 'b';
        $cases['order status-type, status eq, type eq, name -1'] = [-1, $a, $b, ['status', 'type']];

        $a = new Entry();
        $a->status = 'A';
        $a->type = 'dir';
        $a->name = 'b';

        $b = new Entry();
        $b->status = 'A';
        $b->type = 'file';
        $b->name = 'a';
        $cases['order status-type, status eq, type -1, name +1'] = [-1, $a, $b, ['status', 'type']];

        $a = new Entry();
        $a->status = 'A';
        $a->type = 'file';
        $a->name = 'b';

        $b = new Entry();
        $b->status = 'AM';
        $b->type = 'dir';
        $b->name = 'a';
        $cases['order status-type, status -1, type +1, name +1'] = [1, $a, $b, ['status', 'type']];

        return $cases;
    }

    /**
     * @dataProvider casesCompare
     */
    public function testCompare(int $expected, Entry $a, Entry $b, ?array $sortBy = null)
    {
        $comparer = new EntryComparer();
        if ($sortBy !== null) {
            $comparer->setSortBy($sortBy);
        }

        Assert::assertSame($expected, $comparer($a, $b));
    }
}
