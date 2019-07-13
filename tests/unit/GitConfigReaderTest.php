<?php

declare(strict_types = 1);

use Codeception\Test\Unit;
use PHPUnit\Framework\Assert;
use Sweetchuck\GitStatusTree\Color;
use Sweetchuck\GitStatusTree\Config;
use Sweetchuck\GitStatusTree\GitConfigParser;
use Sweetchuck\GitStatusTree\GitConfigReader;
use Symfony\Component\Console\Helper\ProcessHelper;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

/**
 * @covers \Sweetchuck\GitStatusTree\GitConfigReader<extended>
 */
class GitConfigReaderTest extends Unit
{

    public function casesRead(): array
    {
        $cases = [];

        $cases['empty'] = [
            new Config(),
            [],
            [
                'exitCode' => 0,
                'stdOutput' => '',
                'stdError' => '',
            ],
        ];

        $config = new Config();
        $config->showTreeLines = false;
        $config->colors['treelines'] = new Color();
        $config->colors['treelines']->foreGround = 'blue';
        $config->colors['treelines']->backGround = 'red';
        $config->colors['treelines']->bold = true;
        $cases['basic'] = [
            $config,
            [
                'treelines',
            ],
            [
                'exitCode' => 0,
                'stdOutput' => implode("\n", [
                    'status-tree.showtreelines=false',
                    'color.status-tree.treelines=blue red bold',
                    '',
                ]),
                'stdError' => '',
            ],
        ];

        return $cases;
    }

    /**
     * @dataProvider casesRead
     */
    public function testRead(
        Config $expected,
        array $colorsToCheck,
        array $processResult
    ): void {
        /** @var \Symfony\Component\Process\Process|\PHPUnit\Framework\MockObject\MockObject $process */
        $process = $this
            ->getMockBuilder(Process::class)
            ->disableOriginalConstructor()
            ->getMock();
        $process
            ->method('getExitCode')
            ->willReturn($processResult['exitCode']);
        $process
            ->method('getOutput')
            ->willReturn($processResult['stdOutput']);
        $process
            ->method('getErrorOutput')
            ->willReturn($processResult['stdError']);

        /** @var \Symfony\Component\Console\Helper\ProcessHelper|\PHPUnit\Framework\MockObject\MockObject $processHelper */
        $processHelper = $this
            ->getMockBuilder(ProcessHelper::class)
            ->getMock();
        $processHelper
            ->method('run')
            ->will(
                $this->returnCallback(
                    function (OutputInterface $output, $cmd, $error = null, callable $callback = null, $verbosity = OutputInterface::VERBOSITY_VERY_VERBOSE) use ($processResult, $process) {
                        if ($callback) {
                            $callback('out', $processResult['stdOutput']);
                            $callback('err', $processResult['stdError']);
                        }

                        return $process;
                    }
                )
            );

        $parser = new GitConfigParser();
        $reader = new GitConfigReader($processHelper, $parser);
        $reader->setOutput(new BufferedOutput());

        $expectedColors = $expected->colors;
        $expected->colors = [];

        $actual = $reader->read();
        $actualColors = $actual->colors;
        $actual->colors = [];

        Assert::assertEquals($expected, $actual);
        foreach ($colorsToCheck as $key) {
            Assert::assertEquals($expectedColors[$key], $actualColors[$key]);
        }
    }
}
