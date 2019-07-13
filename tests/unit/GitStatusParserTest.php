<?php

declare(strict_types = 1);

use Codeception\Test\Unit;
use PHPUnit\Framework\Assert;
use Sweetchuck\GitStatusTree\Entry;
use Sweetchuck\GitStatusTree\GitStatusParser;

/**
 * @covers \Sweetchuck\GitStatusTree\GitStatusParser
 */
class GitStatusParserTest extends Unit
{

    public function casesParse(): array
    {
        return [
            'empty' => [
                [],
                '',
            ],
            'basic' => [
                [
                    'name' => '',
                    'status' => '',
                    'children' => [
                        'a' => [
                            'name' => 'a',
                            'status' => '',
                            'children' => [
                                'b' => [
                                    'name' => 'b',
                                    'status' => 'MM',
                                    'children' => [],
                                ],
                                'c' => [
                                    'name' => 'c',
                                    'status' => '!!',
                                    'oldName' => '',
                                    'children' => [],
                                ],
                                'd' => [
                                    'name' => 'd',
                                    'status' => 'RM',
                                    'oldName' => 'e/f',
                                ],
                            ],
                        ],
                    ],
                ],
                implode("\n", [
                    'MM a/b',
                    '!! a/c',
                    'RM e/f -> a/d',
                    '',
                ]),
            ],
        ];
    }

    /**
     * @dataProvider casesParse
     */
    public function testParse(array $expected, string $lines): void
    {
        $parser = new GitStatusParser();
        $this->assertEntryTree($expected, $parser->parse($lines));
    }

    public function assertEntryTree(array $expected, Entry $entry)
    {
        if (array_key_exists('name', $expected)) {
            Assert::assertSame($expected['name'], $entry->name);
        }

        if (array_key_exists('status', $expected)) {
            Assert::assertSame($expected['status'], $entry->status);
        }

        if (array_key_exists('oldName', $expected)) {
            Assert::assertSame($expected['oldName'], $entry->oldName);
        }

        if (array_key_exists('children', $expected)) {
            Assert::assertSameSize($expected['children'], $entry->children);
            foreach ($expected['children'] as $name => $expectedChild) {
                $this->assertEntryTree($expectedChild, $entry->children[$name]);
            }
        }
    }

}
