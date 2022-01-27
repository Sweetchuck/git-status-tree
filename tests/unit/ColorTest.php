<?php

declare(strict_types = 1);

namespace Sweetchuck\GitStatusTree\Tests\Unit;

use Codeception\Test\Unit;
use Sweetchuck\GitStatusTree\Color;
use Sweetchuck\GitStatusTree\Tests\UnitTester;

/**
 * @covers \Sweetchuck\GitStatusTree\Color
 */
class ColorTest extends Unit
{
    protected UnitTester $tester;

    public function testAll()
    {
        $color = new Color();
        $color->underline = true;
        $color->reverse = true;

        $this->tester->assertSame(
            [
                'bold' => false,
                'dim' => false,
                'underscore' => false,
                'underline' => true,
                'blink' => false,
                'reverse' => true,
                'conceal' => false,
            ],
            $color->getOptions(),
        );

        $this->tester->assertSame(
            [
                'underline',
                'reverse',
            ],
            $color->getEnabledOptions(),
        );

        $this->tester->assertSame(
            [
                'bold',
                'dim',
                'underscore',
                'blink',
                'conceal',
            ],
            $color->getDisabledOptions(),
        );
    }
}
