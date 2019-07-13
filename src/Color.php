<?php

declare(strict_types = 1);

namespace Sweetchuck\GitStatusTree;

class Color
{

    /**
     * @var null|string
     */
    public $foreGround = null;

    /**
     * @var null|string
     */
    public $backGround = null;

    /**
     * @var bool
     */
    public $bold = false;

    /**
     * @var bool
     */
    public $dim = false;

    /**
     * @var bool
     */
    public $underscore = false;

    /**
     * @var bool
     */
    public $underline = false;

    /**
     * @var bool
     */
    public $blink = false;

    /**
     * @var bool
     */
    public $reverse = false;

    /**
     * @var bool
     */
    public $conceal = false;

    public function getOptions(): array
    {
        return [
            'bold' => $this->bold,
            'dim' => $this->dim,
            'underscore' => $this->underscore,
            'underline' => $this->underline,
            'blink' => $this->blink,
            'reverse' => $this->reverse,
            'conceal' => $this->conceal,
        ];
    }

    public function getEnabledOptions(): array
    {
        return array_keys($this->getOptions(), true, true);
    }

    public function getDisabledOptions(): array
    {
        return array_keys($this->getOptions(), false, true);
    }
}
