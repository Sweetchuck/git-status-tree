<?php

declare(strict_types = 1);

namespace Sweetchuck\GitStatusTree\Tests;

use Sweetchuck\GitStatusTree\Entry;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
 */
class UnitTester extends \Codeception\Actor
{
    use _generated\UnitTesterActions;

    public function assertEntryTree(array $expected, Entry $entry)
    {
        if (array_key_exists('name', $expected)) {
            $this->assertSame($expected['name'], $entry->name);
        }

        if (array_key_exists('status', $expected)) {
            $this->assertSame($expected['status'], $entry->status);
        }

        if (array_key_exists('oldName', $expected)) {
            $this->assertSame($expected['oldName'], $entry->oldName);
        }

        if (array_key_exists('children', $expected)) {
            $this->assertSameSize($expected['children'], $entry->children);
            foreach ($expected['children'] as $name => $expectedChild) {
                $this->assertEntryTree($expectedChild, $entry->children[$name]);
            }
        }
    }
}
