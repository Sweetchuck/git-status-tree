<?php

declare(strict_types = 1);

use Codeception\Test\Unit;
use PHPUnit\Framework\Assert;
use Sweetchuck\GitStatusTree\Color;

/**
 * @covers \Sweetchuck\GitStatusTree\Color
 */
class ColorTest extends Unit
{

    public function testAll()
    {
        $color = new Color();
        $color->underline = true;
        $color->reverse = true;

        Assert::assertSame(
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

        Assert::assertSame(
            [
                'underline',
                'reverse',
            ],
            $color->getEnabledOptions(),
        );

        Assert::assertSame(
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
