<?php

declare(strict_types = 1);

namespace Sweetchuck\GitStatusTree;

use Symfony\Component\Console\Helper\ProcessHelper;
use Symfony\Component\Console\Output\OutputInterface;

class GitCommandBase
{

    protected ?OutputInterface $output;

    public function output(): ?OutputInterface
    {
        return $this->output;
    }

    public function setOutput(?OutputInterface $output)
    {
        $this->output = $output;

        return $this;
    }

    protected string $stdOutput = '';

    protected string $stdError = '';

    protected ProcessHelper $processHelper;

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
