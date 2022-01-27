<?php

declare(strict_types = 1);

namespace Sweetchuck\GitStatusTree;

class Config
{
    public ?bool $colorize = null;

    public bool $colorizeStatus = true;

    public bool $colorizeFileName = true;

    /**
     * @var \Sweetchuck\GitStatusTree\Color[]
     */
    public array $colors = [];

    public bool $showTreeLines = true;

    public array $sortBy = ['type'];

    public bool $showStatus = true;

    public int $indentSize = 4;

    public bool $groupEmptyDirs = true;

    public string $treeLineCharChild = '├';

    public string $treeLineCharChildLast = '└';

    public string $treeLineCharVertical = '│';

    public string $treeLineCharHorizontal = '─';

    protected static array $propertyMapping = [
        'colorize' => 'colorize',
        'colorizestatus' => 'colorizeStatus',
        'colorizefilename' => 'colorizeFileName',
        'colors' => 'colors',
        'showtreelines' => 'showTreeLines',
        'sortby' => 'sortBy',
        'showstatus' => 'showStatus',
        'indentsize' => 'indentSize',
        'groupemptydirs' => 'groupEmptyDirs',
        'treelinecharchild' => 'treeLineCharChild',
        'treelinecharchildlast' => 'treeLineCharChildLast',
        'treelinecharvertical' => 'treeLineCharVertical',
        'treelinecharhorizontal' => 'treeLineCharHorizontal',
    ];

    public function __clone()
    {
        foreach (array_keys($this->colors) as $key) {
            $this->colors[$key] = clone $this->colors[$key];
        }
    }

    public static function __set_state($values)
    {
        $instance = new static();

        foreach ($values as $key => $value) {
            if ($key === 'color.status-tree') {
                $instance->colorize = $value;

                continue;
            }

            $matches = [];
            if (preg_match('/^status-tree\.(?P<external>.+)/u', $key, $matches)
                && array_key_exists($matches['external'], static::$propertyMapping)
            ) {
                $internal = static::$propertyMapping[$matches['external']];
                $instance->{$internal} = $value;

                continue;
            }

            $matches = [];
            if (preg_match('/^color\.status-tree\.(?P<external>.+)/u', $key, $matches)) {
                $instance->colors[$matches['external']] = $value;
            }
        }

        return $instance;
    }
}
