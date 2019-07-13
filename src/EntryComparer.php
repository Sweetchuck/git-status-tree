<?php

declare(strict_types = 1);

namespace Sweetchuck\GitStatusTree;

class EntryComparer
{
    /**
     * @var string[]
     */
    protected $sortBy = ['type', 'name'];

    public function getSortBy(): array
    {
        return $this->sortBy;
    }

    /**
     * @return $this
     */
    public function setSortBy(array $sortBy)
    {
        $this->sortBy = $sortBy;

        return $this;
    }

    public function __invoke(Entry $a, Entry $b): int
    {
        return $this->compare($a, $b);
    }

    public function compare(Entry $a, Entry $b): int
    {
        $typeWeights = $this->getTypeWeights();
        $statuses = GitStatusParser::getStatuses();
        foreach ($this->getSortBy() as $sortBy) {
            switch ($sortBy) {
                case 'type':
                    $result = $typeWeights[$a->type] <=> $typeWeights[$b->type];
                    break;

                case 'status':
                    $aWeight = $statuses[$a->status]['weight'] ?? 50;
                    $bWeight = $statuses[$b->status]['weight'] ?? 50;
                    $result = $aWeight <=> $bWeight;
                    break;

                default:
                    $result = 0;
            }

            if ($result !== 0) {
                return $result;
            }
        }

        return strnatcmp($a->name, $b->name);
    }

    /**
     * @return int[]
     */
    protected function getTypeWeights(): array
    {
        return array_flip([
            'dir',
            'file',
        ]);
    }
}
