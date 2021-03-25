<?php
/**
 * AbraFlexi Bricks
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */

namespace AbraFlexi\ui;

/**
 * Description of TypSklPohSelect
 *
 * @author vitex
 */
class RecordTypeSelect extends \Ease\Html\SelectTag
{

    /**
     * Common AbraFlexi evidence record Type Select
     *
     * @param \AbraFlexi\RO $engine
     * @param string $valueType Column with return value eg. kod
     * @param array $conditons Additonal conditions
     */
    public function __construct($engine, $valueType = 'id', $conditions = [])
    {
        if (!isset($conditions['order'])) {
            $conditions['order'] = 'nazev';
        }
        $typesRaw = $engine->getColumnsFromAbraFlexi(['nazev', $valueType],
            $conditions);

        $types = ['' => _('Undefined')];
        if (!empty($typesRaw)) {
            foreach ($typesRaw as $type) {
                $types[($valueType == 'kod' ? 'code:' : '').$type[$valueType]] = $type['nazev'];
            }
        }
        $default = $engine->getDataValue($valueType);

        parent::__construct($engine->getEvidence(), $types, ( $valueType == 'kod' && !empty($default) ? \AbraFlexi\RO::code($default) : $default));
    }
}
