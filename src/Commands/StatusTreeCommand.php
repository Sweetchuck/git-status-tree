<?php

declare(strict_types = 1);

namespace Sweetchuck\GitStatusTree\Commands;

use Sweetchuck\GitStatusTree\GitConfigReader;
use Sweetchuck\GitStatusTree\GitStatusParser;
use Sweetchuck\GitStatusTree\GitStatusReader;
use Sweetchuck\GitStatusTree\GitStatusRenderer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class StatusTreeCommand extends Command
{

    protected ?GitConfigReader $configReader = null;

    protected ?GitStatusReader $statusReader = null;

    protected ?GitStatusRenderer $statusRenderer = null;

    public function __construct(
        string $name = null,
        ?GitConfigReader $configReader = null,
        ?GitStatusReader $statusReader = null,
        ?GitStatusRenderer $statusRenderer = null
    ) {
        $this->configReader = $configReader;
        $this->statusReader = $statusReader;
        $this->statusRenderer = $statusRenderer;
        parent::__construct($name);
    }

    protected function configure()
    {
        parent::configure();

        $this
            ->setDescription('Shows Git status hierarchically')
            ->addOption(
                'ignored',
                null,
                InputOption::VALUE_OPTIONAL,
                'Show ignored files as well.',
                false,
            )
            ->addOption(
                'untracked-files',
                'u',
                InputOption::VALUE_OPTIONAL,
                'Show untracked files',
                false,
            )
            ->addArgument(
                'paths',
                InputArgument::IS_ARRAY,
                'Paths',
                [],
            );
    }

    protected function init(InputInterface $input, OutputInterface $output)
    {
        /** @var \Symfony\Component\Console\Helper\ProcessHelper $processHelper */
        $processHelper = $this
            ->getApplication()
            ->getHelperSet()
            ->get('process');

        if (!$this->configReader) {
            $this->configReader = new GitConfigReader($processHelper);
            $this->configReader->setOutput($output);
        }

        if (!$this->statusReader) {
            $this->statusReader = new GitStatusReader(
                $processHelper,
                new GitStatusParser(),
            );
            $this->statusReader->setOutput($output);
        }

        if (!$this->statusRenderer) {
            $this->statusRenderer = new GitStatusRenderer();
        }

        return $this;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->init($input, $output);

        $status = $this
            ->statusReader
            ->read(
                null,
                [
                    'ignored' => $input->getOption('ignored'),
                    'untracked-files' => $input->getOption('untracked-files'),
                ],
                $input->getArgument('paths'),
            );
        $config = $this->configReader->read();

        if ($config->colorize === null) {
            $config->colorize = $output->isDecorated();
        }

        $this->statusRenderer->render($output, $status, $config);

        return 0;
    }
}
