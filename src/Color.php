<?php

declare(strict_types = 1);

namespace Sweetchuck\GitStatusTree;

class Color
{

    public ?string $foreGround = null;

    public ?string $backGround = null;

    public bool $bold = false;

    public bool $dim = false;

    public bool $underscore = false;

    public bool $underline = false;

    public bool $blink = false;

    public bool $reverse = false;

    public bool $conceal = false;

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
