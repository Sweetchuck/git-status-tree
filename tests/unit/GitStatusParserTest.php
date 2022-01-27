<?php

declare(strict_types = 1);

namespace Sweetchuck\GitStatusTree\Tests\Unit;

use Codeception\Test\Unit;
use Sweetchuck\GitStatusTree\GitStatusParser;
use Sweetchuck\GitStatusTree\Tests\UnitTester;

/**
 * @covers \Sweetchuck\GitStatusTree\GitStatusParser
 */
class GitStatusParserTest extends Unit
{
    protected UnitTester $tester;

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
        $this->tester->assertEntryTree($expected, $parser->parse($lines));
    }
}
