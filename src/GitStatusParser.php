<?php

declare(strict_types = 1);

namespace Sweetchuck\GitStatusTree;

class GitStatusParser
{

    /**
     * @var array
     */
    protected static $statuses = [
        'Ax' => [
            'label' => 'added to index',
        ],
        'AM' => [
            'label' => 'added to index',
        ],
        'AD' => [
            'label' => 'added to index',
        ],
        'Mx' => [
            'label' => 'updated in index',
        ],
        'MM' => [
            'label' => 'updated in index',
        ],
        'MD' => [
            'label' => 'updated in index',
        ],
        'Dx' => [
            'label' => 'deleted from index',
        ],
        'Rx' => [
            'label' => 'renamed in index',
        ],
        'RM' => [
            'label' => 'renamed in index',
        ],
        'RD' => [
            'label' => 'renamed in index',
        ],
        'Cx' => [
            'label' => 'copied in index',
        ],
        'CM' => [
            'label' => 'copied in index',
        ],
        'CD' => [
            'label' => 'copied in index',
        ],
        'xR' => [
            'label' => 'renamed in work tree',
        ],
        'DR' => [
            'label' => 'renamed in work tree',
        ],
        'xC' => [
            'label' => 'copied in work tree',
        ],
        'DC' => [
            'label' => 'copied in work tree',
        ],

        'DD' => [
            'label' => 'unmerged, both deleted',
        ],
        'AU' => [
            'label' => 'unmerged, added by us',
        ],
        'UD' => [
            'label' => 'unmerged, deleted by them',
        ],
        'UA' => [
            'label' => 'unmerged, added by them',
        ],
        'DU' => [
            'label' => 'unmerged, deleted by us',
        ],
        'AA' => [
            'label' => 'unmerged, both added',
        ],
        'UU' => [
            'label' => 'unmerged, both modified',
        ],

        'xA' => [
            'label' => 'not updated',
        ],
        'xM' => [
            'label' => 'not updated',
        ],
        'xD' => [
            'label' => 'not updated',
        ],

        '??' => [
            'label' => 'untracked',
            'machine' => 'qq',
        ],
        '!!' => [
            'label' => 'ignored',
            'machine' => 'ee',
        ],
    ];

    public static function getStatuses(): array
    {
        static::initStatuses();

        return static::$statuses;
    }

    protected static function initStatuses()
    {
        if (!empty(static::$statuses['xA']['id'])) {
            return;
        }

        $i = 0;
        foreach (static::$statuses as $id => &$status) {
            $status['id'] = $id;
            $status['weight'] = $i++;
            if (empty($status['human'])) {
                $status['human'] = str_replace('x', ' ', $id);
            }

            if (empty($status['machine'])) {
                $status['machine'] = mb_strtolower($id);
            }
        }
    }

    /**
     * @var string
     */
    protected $renameSeparator = ' -> ';

    public function parse(string $lines): Entry
    {
        $root = new Entry();
        foreach ($this->splitLines($lines) as $line) {
            $oldFileName = '';
            $status = mb_substr($line, 0, 2);
            $fileName = mb_substr($line, 3);
            $status = str_replace(' ', 'x', $status);
            if (mb_strpos($fileName, $this->renameSeparator)) {
                list($oldFileName, $fileName) = explode($this->renameSeparator, $fileName, 2);
            }

            $fileNameParts = explode(DIRECTORY_SEPARATOR, trim($fileName, DIRECTORY_SEPARATOR));
            $child = $root->addChild($fileNameParts, 0, $oldFileName);
            $child->status = $status;
        }

        return $root;
    }

    protected function splitLines(string $lines): array
    {
        $return = preg_split('/[\n\r]+/u', $lines);

        return array_filter($return, 'mb_strlen');
    }
}
