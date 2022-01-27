<?php

declare(strict_types = 1);

namespace Sweetchuck\GitStatusTree;

class GitConfigParser
{

    protected array $schema = [
        'color.status-tree' => [
            'type' => 'mapping',
            'mapping' => [
                'never' => false,
                'auto' => null,
                'always' => true,
            ],
            'default' => 'auto',
        ],

        'color.status-tree.treelines' => [
            'type' => 'color',
            'default' => '',
        ],

        'color.status-tree.status_ax_status' => [
            'type' => 'color',
            'default' => 'normal green',
        ],
        'color.status-tree.status_ax_filename' => [
            'type' => 'color',
            'default' => 'normal green',
        ],
        'color.status-tree.status_am_status' => [
            'type' => 'color',
            'default' => 'normal blue',
        ],
        'color.status-tree.status_am_filename' => [
            'type' => 'color',
            'default' => 'normal blue',
        ],
        'color.status-tree.status_ad_status' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_ad_filename' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_mx_status' => [
            'type' => 'color',
            'default' => 'black green',
        ],
        'color.status-tree.status_mx_filename' => [
            'type' => 'color',
            'default' => 'black green',
        ],
        'color.status-tree.status_mm_status' => [
            'type' => 'color',
            'default' => 'black cyan',
        ],
        'color.status-tree.status_mm_filename' => [
            'type' => 'color',
            'default' => 'cyan',
        ],
        'color.status-tree.status_md_status' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_md_filename' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_dx_status' => [
            'type' => 'color',
            'default' => 'normal red',
        ],
        'color.status-tree.status_dx_filename' => [
            'type' => 'color',
            'default' => 'normal red',
        ],
        'color.status-tree.status_rx_status' => [
            'type' => 'color',
            'default' => 'normal blue',
        ],
        'color.status-tree.status_rx_filename' => [
            'type' => 'color',
            'default' => 'normal blue',
        ],
        'color.status-tree.status_rm_status' => [
            'type' => 'color',
            'default' => 'normal blue',
        ],
        'color.status-tree.status_rm_filename' => [
            'type' => 'color',
            'default' => 'normal blue',
        ],
        'color.status-tree.status_rd_status' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_rd_filename' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_cx_status' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_cx_filename' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_cm_status' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_cm_filename' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_cd_status' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_cd_filename' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_xr_status' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_xr_filename' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_dr_status' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_dr_filename' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_xc_status' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_xc_filename' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_dc_status' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_dc_filename' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_dd_status' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_dd_filename' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_au_status' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_au_filename' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_ud_status' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_ud_filename' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_ua_status' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_ua_filename' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_du_status' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_du_filename' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_aa_status' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_aa_filename' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_uu_status' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_uu_filename' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_xa_status' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_xa_filename' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_xm_status' => [
            'type' => 'color',
            'default' => 'blue',
        ],
        'color.status-tree.status_xm_filename' => [
            'type' => 'color',
            'default' => 'blue',
        ],
        'color.status-tree.status_xd_status' => [
            'type' => 'color',
            'default' => 'red bold',
        ],
        'color.status-tree.status_xd_filename' => [
            'type' => 'color',
            'default' => 'red bold',
        ],
        'color.status-tree.status_qq_status' => [
            'type' => 'color',
            'default' => 'red',
        ],
        'color.status-tree.status_qq_filename' => [
            'type' => 'color',
            'default' => 'red',
        ],
        'color.status-tree.status_ee_status' => [
            'type' => 'color',
            'default' => '',
        ],
        'color.status-tree.status_ee_filename' => [
            'type' => 'color',
            'default' => '',
        ],

        'status-tree.showtreelines' => [
            'type' => 'bool',
            'default' => true,
        ],
        'status-tree.sortby' => [
            'type' => 'list',
            'default' => 'type',
        ],
        'status-tree.showstatus' => [
            'type' => 'bool',
            'default' => true,
        ],
        'status-tree.indentsize' => [
            'type' => 'int',
            'default' => 4,
        ],
        'status-tree.groupemptydirs' => [
            'type' => 'bool',
            'default' => 'true',
        ],
        'status-tree.treelinecharchild' => [
            'type' => 'string',
            'default' => '├',
        ],
        'status-tree.treelinecharchildlast' => [
            'type' => 'string',
            'default' => '└',
        ],
        'status-tree.treelinecharvertical' => [
            'type' => 'string',
            'default' => '│',
        ],
        'status-tree.treelinecharhorizontal' => [
            'type' => 'string',
            'default' => '─',
        ],
        'status-tree.colorizestatus' => [
            'type' => 'bool',
            'default' => true,
        ],
        'status-tree.colorizefilename' => [
            'type' => 'bool',
            'default' => true,
        ],
    ];

    public function parse(string $stdOutput, array $defaultValues = []): Config
    {
        $values = $stdOutput ? parse_ini_string($stdOutput, false, INI_SCANNER_RAW) : [];
        $values += $defaultValues + $this->getDefaultValues();
        $values = array_intersect_key($values, $this->schema);

        foreach ($this->schema as $key => $schema) {
            switch ($schema['type']) {
                case 'int':
                    $values[$key] = intval($values[$key]);
                    break;

                case 'bool':
                    $values[$key] = $values[$key] === true || $values[$key] === 'true';
                    break;

                case 'mapping':
                    $value = $values[$key];
                    if (!array_key_exists($value, $schema['mapping'])) {
                        $value = $schema['default'];
                    }

                    $values[$key] = $schema['mapping'][$value];
                    break;

                case 'list':
                    $values[$key] = preg_split(
                        '/[\s,]+/u',
                        trim($values[$key], "\t\r\n ,"),
                        -1,
                        PREG_SPLIT_NO_EMPTY,
                    );
                    break;

                case 'color':
                    $values[$key] = $this->createColor($values[$key]);
                    break;
            }
        }

        return Config::__set_state($values);
    }

    protected function getDefaultValues(): array
    {
        $values = [];
        foreach ($this->schema as $key => $schema) {
            $values[$key] = $schema['default'] ?? null;
        }

        return  $values;
    }

    protected function createColor(string $value): Color
    {
        $color = new Color();

        $value = trim($value);
        if (!$value) {
            return $color;
        }

        $optionNames = array_keys($color->getOptions());
        $parts = preg_split('/\s+/', $value);
        foreach ($optionNames as $optionName) {
            $color->{$optionName} = in_array($optionName, $parts);
        }

        if (!$color->underline && in_array('ul', $parts)) {
            $color->underline = true;
        }

        $optionNames[] = 'ul';
        $parts = array_diff($parts, $optionNames);
        $color->foreGround = array_shift($parts);
        $color->backGround = array_shift($parts);

        return $color;
    }
}
