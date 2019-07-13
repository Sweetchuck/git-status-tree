<?php

declare(strict_types = 1);

use Codeception\Test\Unit;
use PHPUnit\Framework\Assert;
use Sweetchuck\GitStatusTree\Color;
use Sweetchuck\GitStatusTree\Config;
use Sweetchuck\GitStatusTree\GitConfigParser;

class GitConfigParserTest extends Unit
{

    public function casesParse(): array
    {
        $cases = [];

        $defaultConfig = new Config();
        $cases['empty'] = [$defaultConfig, '', []];

        $config = clone $defaultConfig;
        $config->showTreeLines = false;
        $config->colors['treelines'] = new Color();
        $config->colors['treelines']->foreGround = 'red';
        $config->colors['treelines']->backGround = 'blue';
        $config->colors['treelines']->underline = true;

        $cases['basic'] = [
            $config,
            implode("\n", [
                'color.status-tree.treelines=red blue ul',
                'status-tree.showtreelines=false',
            ]),
            [
                'treelines',
            ],
        ];

        return $cases;
    }

    /**
     * @dataProvider casesParse
     */
    public function testParse(Config $expected, string $stdOutput, array $colorsToCheck): void
    {
        $expectedColors = $expected->colors;
        $expected->colors = [];

        $parser = new GitConfigParser();

        $actual = $parser->parse($stdOutput);
        $actualColors = $actual->colors;
        $actual->colors = [];
        Assert::assertEquals($expected, $actual);

        foreach ($colorsToCheck as $key) {
          Assert::assertEquals($expectedColors[$key], $actualColors[$key]);
        }
    }
}
