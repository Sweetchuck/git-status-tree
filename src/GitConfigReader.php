<?php

declare(strict_types = 1);

namespace Sweetchuck\GitStatusTree;

use Symfony\Component\Console\Helper\ProcessHelper;

class GitConfigReader extends GitCommandBase
{
    /**
     * @var \Sweetchuck\GitStatusTree\GitConfigParser
     */
    protected $parser;

    public function __construct(ProcessHelper $processHelper, ?GitConfigParser $parser = null)
    {
        parent::__construct($processHelper);
        $this->parser = $parser ?: new GitConfigParser();
    }

    public function read(?string $dir = null): Config
    {
        $process = $this->processHelper->run(
            $this->output(),
            $this->getCommand($dir),
            null,
            $this->processWrapperCallback,
        );

        if ($process->getExitCode() !== 0) {
            // @todo Do something on error.
            $this->stdOutput = '';
        }

        return $this->parser->parse($this->stdOutput);
    }

    protected function getCommand(?string $dir = null): array
    {
        $command = [];
        if ($dir && $dir !== '.') {
            $command[] = 'cd';
            $command[] = escapeshellarg($dir);
            $command[] = '&&';
        }

        $command[] = 'git';
        $command[] = 'config';
        $command[] = '--list';

        return $command;
    }
}
