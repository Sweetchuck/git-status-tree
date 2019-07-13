<?php

declare(strict_types = 1);

namespace Sweetchuck\GitStatusTree;

use Symfony\Component\Console\Helper\ProcessHelper;

class GitStatusReader extends GitCommandBase
{

    /**
     * @var \Sweetchuck\GitStatusTree\GitStatusParser
     */
    protected $parser;

    /**
     * {@inheritdoc}
     */
    public function __construct(ProcessHelper $processHelper, ?GitStatusParser $parser = null)
    {
        parent::__construct($processHelper);
        $this->parser = $parser ?: new GitStatusParser();
    }

    public function read(?string $dir = null, array $options = [], array $args = []): Entry
    {
        $process = $this->processHelper->run(
            $this->output(),
            $this->getCommand($dir, $options, $args),
            null,
            $this->processWrapperCallback,
        );

        if ($process->getExitCode() !== 0) {
            // @todo Do something.
            return $this->parser->parse('');
        }

        return $this->parser->parse($this->stdOutput);
    }

    protected function getCommand(?string $dir = null, array $options = [], array $args = []): array
    {
        $command = [];
        if ($dir && $dir !== '.') {
            $command[] = 'cd';
            $command[] = escapeshellarg($dir);
            $command[] = '&&';
        }

        $command[] = 'git';
        $command[] = 'status';
        $command[] = sprintf('--porcelain=%s', 'v1');

        foreach (['ignored', 'untracked-files'] as $optionName) {
            if (array_key_exists($optionName, $options)) {
                if ($options[$optionName] === true || $options[$optionName] === null) {
                    $command[] = "--$optionName";
                } elseif ($options[$optionName]) {
                    $command[] = sprintf("--$optionName=%s", escapeshellarg($options[$optionName]));
                }
            }
        }

        if ($args) {
            $command[] = '--';
            $command = array_merge($command, $args);
        }

        return $command;
    }
}
