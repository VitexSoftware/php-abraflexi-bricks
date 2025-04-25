<?php

declare(strict_types=1);

/**
 * This file is part of the BricksForAbraFlexi package
 *
 * https://github.com/VitexSoftware/php-abraflexi-bricks
 *
 * (c) Vítězslav Dvořák <http://vitexsoftware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AbraFlexi\ui;

/**
 * Select One Value.
 *
 * @deprecated this class is deprecated and will be removed in a future release
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class RecordSelector extends \Ease\Html\SelectTag
{
    use \Ease\ui\Selectizer;

    /**
     * Selectize.js based input.
     *
     * @param string        $name
     * @param string        $value
     * @param \AbraFlexi\RO $optionsEngine
     * @param array         $properties
     */
    public function __construct(
        $name,
        $value,
        $optionsEngine,
        $properties = [],
    ) {
        if (empty($optionsEngine->getColumnInfo('nazev'))) {
            $nameColumn = 'kod';
        } else {
            $nameColumn = 'nazev';
        }

        if (empty($optionsEngine->getColumnInfo('kod'))) {
            $keyColumn = 'id';
        } else {
            $keyColumn = 'kod';
        }

        $values = $optionsEngine->getColumnsFromAbraFlexi([$keyColumn, $nameColumn], ['limit' => 0]);
        $options = [];

        foreach ($values as $id => $valuesRow) {
            $options[$values[$id][$keyColumn]] = $values[$id][$nameColumn];
        }

        parent::__construct($name, $options, $value, [], $properties);

        $this->selectize(['valueField' => $keyColumn, 'labelField' => $nameColumn,
            'searchField' => ['kod', 'nazev'], 'create' => false]);
    }
}
