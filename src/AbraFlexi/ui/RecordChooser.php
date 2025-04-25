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
 * Description of GroupChooser.
 *
 * @deprecated this class is deprecated and will be removed in a future release
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class RecordChooser extends \Ease\Html\InputTextTag
{
    use \Ease\ui\Selectizer;

    /**
     * Selectize.js based Record Chooser.
     *
     * @param string        $name
     * @param array         $values
     * @param \AbraFlexi\RO $optionsEngine
     * @param array         $properties
     */
    public function __construct(
        $name,
        $values,
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

        parent::__construct($name, $values, $properties);
        $values = $optionsEngine->getColumnsFromAbraFlexi([$keyColumn, $nameColumn]);

        if ($keyColumn === 'kod') {
            foreach ($values as $id => $valueRow) {
                $values[$id][$nameColumn] = $values[$id][$keyColumn].': '.$values[$id][$nameColumn];
            }
        }

        $this->selectize(['plugins' => ['remove_button'], 'valueField' => $keyColumn, 'labelField' => $nameColumn, 'searchField' => ['kod', 'nazev'], 'create' => false], $values);
    }
}
