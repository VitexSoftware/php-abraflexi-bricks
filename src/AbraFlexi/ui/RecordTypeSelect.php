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
 * Description of TypSklPohSelect.
 *
 * @author vitex
 */
class RecordTypeSelect extends \Ease\Html\SelectTag
{
    /**
     * Common AbraFlexi evidence record Type Select.
     *
     * @param \AbraFlexi\RO $engine
     * @param string        $valueType  Column with return value eg. kod
     * @param mixed         $conditions
     */
    public function __construct($engine, $valueType = 'id', $conditions = [])
    {
        if (!isset($conditions['order'])) {
            $conditions['order'] = 'nazev';
        }

        $typesRaw = $engine->getColumnsFromAbraFlexi(
            ['nazev', $valueType],
            $conditions,
        );

        $types = ['' => _('Undefined')];

        if (!empty($typesRaw)) {
            foreach ($typesRaw as $type) {
                $types[($valueType === 'kod' ? 'code:' : '').$type[$valueType]] = $type['nazev'];
            }
        }

        $default = $engine->getDataValue($valueType);

        parent::__construct($engine->getEvidence(), $types, $valueType === 'kod' && !empty($default) ? \AbraFlexi\Functions::code((string)$default) : $default);
    }
}
