<?php

declare(strict_types = 1);

namespace Sweetchuck\GitStatusTree;

class Config
{
    /**
     * @var bool|null
     */
    public $colorize = null;

    /**
     * @var bool
     */
    public $colorizeStatus = true;

    /**
     * @var bool
     */
    public $colorizeFileName = true;

    /**
     * @var \Sweetchuck\GitStatusTree\Color[]
     */
    public $colors = [];

    /**
     * @var bool
     */
    public $showTreeLines = true;

    /**
     * @var array
     */
    public $sortBy = ['type'];

    /**
     * @var bool
     */
    public $showStatus = true;

    /**
     * @var int
     */
    public $indentSize = 4;

    /**
     * @var bool
     */
    public $groupEmptyDirs = true;

    /**
     * @var string
     */
    public $treeLineCharChild = '├';

    /**
     * @var string
     */
    public $treeLineCharChildLast = '└';

    /**
     * @var string
     */
    public $treeLineCharVertical = '│';

    /**
     * @var string
     */
    public $treeLineCharHorizontal = '─';

    protected static $propertyMapping = [
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
        foreach ($this->colors as $key => $color) {
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
