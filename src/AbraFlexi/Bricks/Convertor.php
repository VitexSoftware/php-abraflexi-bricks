<?php
/**
 * AbraFlexi Bricks - Convertor Class
 *
 * @author     Vítězslav Dvořák <info@vitexsofware.cz>
 * @copyright  (G) 2017-2020 Vitex Software
 */

namespace AbraFlexi\Bricks;

/**
 * Description of Convertor
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class Convertor extends \Ease\Sand
{
    /**
     * Source Object
     * @var \AbraFlexi\FlexiBeeRO 
     */
    private $input;

    /**
     * Destination Object
     * @var \AbraFlexi\FlexiBeeRO 
     */
    private $output;

    /**
     *
     * @var array 
     */
    private $rules = [];

    /**
     * Convertor 
     * 
     * @param \AbraFlexi\FlexiBeeRO $input   Source 
     * @param \AbraFlexi\FlexiBeeRW $output  Destination
     * @param ConvertorRule          $ruler   force convertor rule class
     */
    public function __construct(\AbraFlexi\FlexiBeeRO $input = null,
                                \AbraFlexi\FlexiBeeRW $output = null,
                                $ruler = null)
    {
        if (!empty($input)) {
            $this->setSource($input);
        }
        if (!empty($output)) {
            $this->setDestination($output);
        }
        if (is_object($ruler)) {
            $this->rules = $ruler;
            $this->rules->assignConvertor($this);
        }
    }

    /**
     * Set Source Documnet
     * 
     * @param \AbraFlexi\FlexiBeeRO $source
     */
    public function setSource(\AbraFlexi\FlexiBeeRO $source)
    {
        $this->input = $source;
    }

    /**
     * Set Destination document
     * 
     * @param \AbraFlexi\FlexiBeeRO $destinantion
     */
    public function setDestination(\AbraFlexi\FlexiBeeRO $destination)
    {
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
     * @return \AbraFlexi\FlexiBeeRW converted object ( unsaved )
     */
    public function conversion($keepId = false, $addExtId = false,
                               $keepCode = false, $handleAccounting = false)
    {
        $this->prepareRules($keepId, $addExtId, $keepCode, $handleAccounting);
        $this->convertDocument();
        return $this->output;
    }

    /**
     * Get Classname without namespace prefix
     * 
     * @param object $object
     * 
     * @return string
     */
    static public function baseClassName($object)
    {
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
    public function prepareRules($keepId, $addExtId, $keepCode,
                                 $handleAccounting)
    {
        $convertorClassname = $this->getConvertorClassName();
        $ruleClass          = '\\AbraFlexi\\Bricks\\ConvertRules\\'.$convertorClassname;
        if (class_exists($ruleClass, true)) {
            $this->rules = new $ruleClass($this, $keepId, $addExtId, $keepCode,
                $handleAccounting);
            $this->rules->assignConvertor($this);
        } else {
            if ($this->debug === true) {
                ConvertorRule::convertorClassTemplateGenerator($this,
                    $convertorClassname);
            }
            throw new \Ease\Exception(sprintf(_('Cannot Load Class: %s'),
                    $ruleClass));
        }
    }

    /**
     * Name for class with rules for converting $this->input to $this->output
     * 
     * @return string
     */
    public function getConvertorClassName()
    {
        return self::baseClassName($this->input).'_to_'.self::baseClassName($this->output);
    }

    /**
     * Convert FlexiBee document
     * 
     * @param boolean $keepId           keep item IDs
     * @param boolean $addExtId         add ext:originalEvidence:originalId 
     * @param boolean $keepCode         keep items code
     * @param boolean $handleAccounting set item's "ucetni" like target 
     */
    public function convertDocument($keepId = false, $addExtId = false,
                                    $keepCode = false, $handleAccountig = false)
    {
        $this->convertItems($keepId, $addExtId, $keepCode, $handleAccountig);
    }

    /**
     * Convert FlexiBee documnet's subitems
     * 
     * @param string  $columnToTake   usually "polozkyDokladu"
     */
    public function convertSubitems($columnToTake)
    {
        $subitemRules = $this->rules->getRuleForColumn($columnToTake);
        if (self::isAssoc($this->input->data[$columnToTake])) {
            $sourceData = [$this->input->data[$columnToTake]];
        } else {
            $sourceData = $this->input->getDataValue($columnToTake);
        }
        $subItemCopyData = [];
        foreach ($sourceData as $subitemPos => $subItemData) {
            foreach (array_keys($subItemData) as $subitemColumn) {
                if (array_key_exists($subitemColumn, $subitemRules)) {
                    if (strstr($subitemRules[$subitemColumn], '()')) {
                        $subItemCopyData[$subitemColumn] = call_user_func(array(
                            $this->rules, str_replace('()', '',
                                $subitemRules[$subitemColumn])),
                            $sourceData[$subitemPos][$subitemColumn]);
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
    public function convertItems()
    {
        $convertRules = $this->rules->getRules();
        foreach ($convertRules as $columnToTake => $subitemColumns) {
            if (is_array($subitemColumns)) {
                if (!empty($this->input->getSubItems())) {
                    $this->convertSubitems($columnToTake);
                }
            } else {
                if (empty($this->output->getDataValue($columnToTake))) {
                    if (strstr($subitemColumns, '()')) {
                        $functionResult = call_user_func(array($this->rules, str_replace('()','', $subitemColumns)),  $this->input->getDataValue($columnToTake));
                        if(!is_null($functionResult)){
                        $this->output->setDataValue($columnToTake,  $functionResult  );
                        }
                    } else {
                        $this->output->setDataValue($columnToTake,
                            $this->input->getDataValue($subitemColumns));
                    }
                }
            }
        }
        return $this->rules->finalizeConversion();
    }

    /**
     * Return itemes that same on both sides
     * 
     * @return array
     */
    public function commonItems()
    {
        return array_intersect(array_keys($this->input->getColumnsInfo()),
            array_keys($this->output->getColumnsInfo()));
    }

    /**
     * Get input object here
     * 
     * @return \AbraFlexi\FlexiBeeRO
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Get output object here
     * 
     * @return \AbraFlexi\FlexiBeeRO
     */
    public function getOutput()
    {
        return $this->output;
    }
}
