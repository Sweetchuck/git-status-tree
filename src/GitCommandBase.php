<?php

declare(strict_types = 1);

namespace Sweetchuck\GitStatusTree;

use Symfony\Component\Console\Helper\ProcessHelper;
use Symfony\Component\Console\Output\OutputInterface;

class GitCommandBase
{

    /** @var null|\Symfony\Component\Console\Output\OutputInterface */
    protected $output;

    /**
     * @return null|\Symfony\Component\Console\Output\OutputInterface
     */
    public function output()
    {
        return $this->output;
    }

    public function setOutput(?OutputInterface $output)
    {
        $this->output = $output;

        return $this;
    }

    /**
     * @var string
     */
    protected $stdOutput = '';

    /**
     * @var string
     */
    protected $stdError = '';

    /**
     * @var \Symfony\Component\Console\Helper\ProcessHelper
     */
    protected $processHelper;

    /**
     * @var callable
     */
    protected $processWrapperCallback;

    public function __construct(ProcessHelper $processHelper)
    {
        $this->processHelper = $processHelper;
        $this->initProcessWrapperCallback();
    }

    /**
     * @return $this
     */
    protected function initProcessWrapperCallback()
    {
        $this->processWrapperCallback = function (string $type, string $text) {
            switch ($type) {
                case 'out':
                    $this->stdOutput .= $text;
                    break;

                default:
                    $this->stdError .= $text;
                    break;
            }
        };

        return $this;
    }
}
