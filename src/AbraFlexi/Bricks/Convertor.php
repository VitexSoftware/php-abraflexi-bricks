<?php

/**
 * AbraFlexi Bricks - Convertor Class
 *
 * @author     Vítězslav Dvořák <info@vitexsofware.cz>
 * @copyright  (G) 2017-2024 Vitex Software
 */

namespace AbraFlexi\Bricks;

/**
 * Description of Convertor
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class Convertor extends \Ease\Sand {

    /**
     * Source Object
     * @var \AbraFlexi\RO
     */
    private $input;

    /**
     * Destination Object
     * @var \AbraFlexi\RO
     */
    private $output;

    /**
     * Keep the conversion rules
     * @var \AbraFlexi\Bricks\ConvertorRule
     */
    private $ruler;

    /**
     * 
     * @var boolean
     */
    public $debug = false;

    /**
     * Convertor
     *
     * @param \AbraFlexi\RO $input   Source
     * @param \AbraFlexi\RW $output  Destination
     * @param ConvertorRule $ruler   force convertor rule class
     */
    public function __construct(
            \AbraFlexi\RO $input = null,
            \AbraFlexi\RW $output = null,
            $ruler = null
    ) {
        if (!empty($input)) {
            $this->setSource($input);
        }
        if (!empty($output)) {
            $this->setDestination($output);
        }
        if (is_object($ruler)) {
            $this->ruler = $ruler;
            $this->ruler->assignConvertor($this);
        }
    }

    /**
     * Set Source Document
     *
     * @param \AbraFlexi\RO $source
     */
    public function setSource(\AbraFlexi\RO $source) {
        $this->input = $source;
    }

    /**
     * Set Destination document
     *
     * @param \AbraFlexi\RO $destinantion
     */
    public function setDestination(\AbraFlexi\RO $destination) {
        $this->output = $destination;
    }

    /**
     * Perform Conversion
     *
     * @param boolean $keepId
     * @param boolean $addExtId
     * @param boolean $keepCode
     * @param boolean $handleAccounting set columns "ucetni" like target or ignore it
     *
     * @return \AbraFlexi\RW converted object ( unsaved )
     */
    public function conversion(
            $keepId = false,
            $addExtId = false,
            $keepCode = false,
            $handleAccounting = false
    ) {
        $this->prepareRules($keepId, $addExtId, $keepCode, $handleAccounting);
        $this->convertItems();
        return $this->getOutput();
    }

    /**
     * Get ClassName without NameSpace prefix
     *
     * @param object $object
     *
     * @return string
     */
    public static function baseClassName($object) {
        return basename(str_replace('\\', '/', get_class($object)));
    }

    /**
     * Prepare conversion rules; in debug mode generate new empty new convertRule file
     *
     * @param boolean $keepId           Keep original ID in cloned document
     * @param boolean $addExtId         Add automatically generated ext:id based on source
     * @param boolean $keepCode         Keep original code: in cloned document
     * @param boolean $handleAccounting set columns "ucetni" like source or ignore it
     *
     * @throws \Ease\Exception
     */
    public function prepareRules(
            $keepId,
            $addExtId,
            $keepCode,
            $handleAccounting
    ) {
        $convertorClassname = $this->getConvertorClassName();
        $ruleClass = '\\AbraFlexi\\Bricks\\ConvertRules\\' . $convertorClassname;
        if (class_exists($ruleClass, true)) {
            $this->ruler = new $ruleClass($this, $keepId, $addExtId, $keepCode, $handleAccounting);
            //$this->rules->assignConvertor($this);
        } else {
            if ($this->debug === true) {
                ConvertorRule::convertorClassTemplateGenerator($this, $convertorClassname);
            }
            throw new \Ease\Exception(sprintf(_('Cannot Load Class: %s'), $ruleClass));
        }
    }

    /**
     * Name for class with rules for converting $this->input to $this->output
     *
     * @return string
     */
    public function getConvertorClassName() {
        return self::baseClassName($this->input) . '_to_' . self::baseClassName($this->output);
    }

    /**
     * Convert AbraFlexi documnet's subitems
     *
     * @param string  $columnToTake   usually "polozkyDokladu"
     */
    public function convertSubitems($columnToTake) {
        $subitemRules = $this->ruler->getRuleForColumn($columnToTake);
        if (is_array($this->input->data[$columnToTake]) && \Ease\Functions::isAssoc($this->input->data[$columnToTake])) {
            $sourceData = [$this->input->data[$columnToTake]];
        } else {
            $sourceData = $this->input->getDataValue($columnToTake);
        }
        $subItemCopyData = [];
        foreach ($sourceData as $subitemPos => $subItemData) {
            foreach (array_keys($subItemData) as $subitemColumn) {
                if (array_key_exists($subitemColumn, $subitemRules)) {
                    if (strstr($subitemRules[$subitemColumn], '()')) {
                        $subItemCopyData[$subitemColumn] = call_user_func(
                                array(
                                    $this->ruler, str_replace(
                                            '()',
                                            '',
                                            $subitemRules[$subitemColumn]
                                    )),
                                $sourceData[$subitemPos][$subitemColumn]
                        );
                    } else {
                        $subItemCopyData[$subitemColumn] = $sourceData[$subitemPos][$subitemRules[$subitemColumn]];
                    }
                }
            }
            $this->output->addArrayToBranch($subItemCopyData);
        }
    }

    /**
     * convert main document items
     *
     * @return boolean conversion success
     */
    public function convertItems() {
        $convertRules = $this->ruler->getRules();
        foreach ($convertRules as $columnToTake => $subitemColumns) {
            if (is_array($subitemColumns)) {
                if (!empty($this->input->getSubItems())) {
                    $this->convertSubitems($columnToTake);
                }
            } else {
                if (empty($this->output->getDataValue($columnToTake))) {
                    if (!empty($subitemColumns) && strstr($subitemColumns, '()')) {
                        $functionResult = call_user_func(
                                array($this->ruler, str_replace(
                                            '()',
                                            '',
                                            $subitemColumns
                                    )),
                                $this->input->getDataValue($columnToTake)
                        );
                        if (!is_null($functionResult)) {
                            $this->output->setDataValue(
                                    $columnToTake,
                                    $functionResult
                            );
                        }
                    } else {
                        $this->output->setDataValue(
                                $columnToTake,
                                $this->input->getDataValue($subitemColumns)
                        );
                    }
                }
            }
        }
        return $this->ruler->finalizeConversion();
    }

    /**
     * Return items that same on both sides
     *
     * @return array
     */
    public function commonItems() {
        return array_intersect(
                array_keys($this->input->getColumnsInfo()),
                array_keys($this->output->getColumnsInfo())
        );
    }

    /**
     * Get input object here
     *
     * @return \AbraFlexi\RO
     */
    public function getInput() {
        return $this->input;
    }

    /**
     * Get output object here
     *
     * @return \AbraFlexi\RO
     */
    public function getOutput() {
        return $this->output;
    }
}
