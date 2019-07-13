<?php

declare(strict_types = 1);

namespace Sweetchuck\GitStatusTree;

use PBergman\Console\Helper\TreeHelper;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\OutputInterface;

class GitStatusRenderer
{

    /**
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    protected $output;

    /**
     * @var \Sweetchuck\GitStatusTree\EntryComparer
     */
    protected $comparer;

    /**
     * @var \Sweetchuck\GitStatusTree\Config
     */
    protected $config;

    /**
     * @var string[]
     */
    protected $treeLineChars = [];

    public function __construct(?EntryComparer $comparer = null)
    {
        $this->comparer = $comparer ?? new EntryComparer();
    }

    public function render(
        OutputInterface $output,
        Entry $entry,
        Config $config
    ) {
        if (!$entry->children) {
            return $this;
        }

        $this->output = $output;
        $this->config = $config;
        $this
            ->initComparer()
            ->initOutputFormatterStyles()
            ->initTreeLineChars();

        $tree = new TreeHelper();
        $tree->setFormats([
            TreeHelper::LINE_PREFIX_EMPTY => $this->treeLineChars['empty'],
            TreeHelper::LINE_PREFIX => $this->treeLineChars['vertical'],
            TreeHelper::TEXT_PREFIX => $this->treeLineChars['childHorizontal'],
            TreeHelper::TEXT_PREFIX_END => $this->treeLineChars['childLast'],
        ]);

        $this->buildTree($entry, $tree);
        $tree->printTree($this->output);

        return $this;
    }

    protected function buildTree(Entry $entry, TreeHelper $tree)
    {
        if ($entry->parent !== null) {
            $node = $tree->newNode($this->getLabel($entry));
        }

        usort($entry->children, $this->comparer);
        foreach ($entry->children as $child) {
            $this->buildTree($child, $node ?? $tree);
        }

        return $this;
    }

    protected function getLabel(Entry $entry): string
    {
        $label = [];

        $statuses = GitStatusParser::getStatuses();
        $status = $statuses[$entry->status] ?? ['human' => '  '];
        $colorize = $this->config->colorize && !empty($status['id']);
        if ($this->config->showStatus) {
            $human = $status['human'];
            if ($colorize && $this->config->colorizeStatus) {
                $format = '<status_%s_status>%s</>';
                if (mb_substr($status['machine'], 0, 1) === 'x') {
                    $format = ' <status_%s_status>%s</>';

                } elseif (mb_substr($status['machine'], -1) === 'x') {
                    $format = '<status_%s_status>%s</> ';
                }

                $human = sprintf($format, $status['machine'], OutputFormatter::escape(trim($status['human'])));
            }

            $label[] = $human;
        }

        $label[] = $colorize && $this->config->colorizeFileName ?
            sprintf('<status_%s_filename>%s</>', $status['machine'], OutputFormatter::escape($entry->name))
            : $entry->name;

        if ($entry->oldName) {
            $label[] = '<- ' . $entry->oldName;
        }

        return implode(' ', $label);
    }

    protected function decoratedTreeLineChar(string $char): string
    {
        if (!$this->config->colorize || !trim($char)) {
            return $char;
        }

        return '<treelines>' . OutputFormatter::escape($char) . '</>';
    }

    protected function initComparer()
    {
        $this->comparer->setSortBy($this->config->sortBy);

        return $this;
    }

    protected function initOutputFormatterStyles()
    {
        $formatter = $this->output->getFormatter();
        foreach ($this->config->colors as $key => $color) {
            $formatter->setStyle(
                $key,
                new OutputFormatterStyle(
                    (!$color->foreGround || $color->foreGround === 'normal' ? null : $color->foreGround),
                    (!$color->backGround || $color->backGround === 'normal' ? null : $color->backGround),
                    $color->getEnabledOptions(),
                ),
            );
        }

        return $this;
    }

    protected function initTreeLineChars()
    {
        $indentSize = $this->config->indentSize;
        $indent = str_repeat(' ', $indentSize);
        $this->treeLineChars = $this->config->showTreeLines ?
            [
                'empty' => $indent,
                'vertical' => $this->decoratedTreeLineChar(
                    $this->config->treeLineCharVertical .
                    str_repeat(' ', $indentSize - 1)
                ),
                'childHorizontal' => $this->decoratedTreeLineChar(
                    $this->config->treeLineCharChild .
                    str_repeat($this->config->treeLineCharHorizontal, $indentSize - 2)
                ) . ' ',
                'childLast' => $this->decoratedTreeLineChar(
                    $this->config->treeLineCharChildLast .
                    str_repeat($this->config->treeLineCharHorizontal, $indentSize - 2)
                ) . ' ',
            ]
            : [
                'empty' => $indent,
                'vertical' => $indent,
                'childHorizontal' => $indent,
                'childLast' => $indent,
            ];

        return $this;
    }
}
