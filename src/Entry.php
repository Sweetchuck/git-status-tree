<?php

declare(strict_types = 1);

namespace Sweetchuck\GitStatusTree;

use AssertionError;

class Entry
{

    /**
     * @var string
     */
    public $status = '';

    /**
     * @var string
     */
    public $name = '';

    /**
     * @var string
     */
    public $oldName = '';

    /**
     * @var null|static
     */
    public $parent = null;

    /**
     * @var string
     */
    public $type = 'file';

    /**
     * @var static[]
     */
    public $children = [];

    /**
     * @var string
     */
    public $baseDir = '.';

    public function getPathname()
    {
        $parents = $this->parent === null ? $this->baseDir : $this->parent->getPathname();

        return $parents . DIRECTORY_SEPARATOR . $this->name;
    }

    /**
     * @return static
     */
    public function addChild(array $paths, int $index = 0, string $oldFileName = '')
    {
        assert(
            $index < count($paths),
            new AssertionError("Out of bound index=$index " . implode(',', $paths)),
        );

        $name = $paths[$index];
        if (!array_key_exists($name, $this->children)) {
            $this->createChild($name);
        }

        if (count($paths) - 1 === $index) {
            $this->children[$name]->oldName = $oldFileName;

            return  $this->children[$name];
        }

        return $this->children[$name]->addChild($paths, $index + 1, $oldFileName);
    }

    /**
     * @return static
     */
    protected function createChild(string $name)
    {
        $this->children[$name] = new static();
        $this->children[$name]->parent = $this;
        $this->children[$name]->name = $name;
        $this->children[$name]->type = is_dir($this->children[$name]->getPathname()) ? 'dir' : 'file';

        return $this->children[$name];
    }
}
