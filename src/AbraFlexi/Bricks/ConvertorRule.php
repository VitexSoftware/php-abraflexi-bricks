<?php
/**
 * AbraFlexi Bricks - Convertor Class Rule
 *
 * @author     Vítězslav Dvořák <info@vitexsofware.cz>
 * @copyright  (G) 2017-2020 Vitex Software
 */

namespace AbraFlexi\Bricks;

/**
 * Description of ConvertorRule
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class ConvertorRule extends \Ease\Sand
{
    /**
     *
     * @var array 
     */
    public $rules     = [];

    /**
     *
     * @var Convertor 
     */
    public $convertor = null;

    /**
     *
     * @var boolean 
     */
    private $keepId   = null;

    /**
     *
     * @var boolean 
     */
    private $addExtId = null;

    /**
     *
     * @var boolean 
     */
    private $keepCode = null;

    /**
     * Conversion Rule
     * 
     * @param Convertor $convertor Convertor Engine
     * @param boolean $keepId           Keep original ID in cloned document
     * @param boolean $addExtId         Add automatically generated ext:id based on source
     * @param boolean $keepCode         Keep original code: in cloned document
     * @param boolean $handleAccounting set columns "ucetni" like target or ignore it
     */
    public function __construct(Convertor &$convertor = null, $keepId = false,
                                $addExtId = false, $keepCode = false,
                                $handleAccounting = true)
    {
        $this->keepId   = $keepId;
        $this->addExtId = $addExtId;
        $this->keepCode = $keepCode;

        if ($convertor) {
            $this->assignConvertor($convertor);
        }

        if ($keepId === false) {
            unset($this->rules['id']);
        }
        if ($addExtId) {
            $this->rules['id'] = 'addExtId()';
        }
        if ($keepCode === false) {
            unset($this->rules['kod']);
        }
        if ($handleAccounting) {

//            unset($this->rules['ucetni']);
//            unset($this->rules['clenDph']);
        }
    }

    /**
     * 
     * @param Convertor $convertor
     */
    public function assignConvertor(Convertor &$convertor)
    {
        $this->convertor = &$convertor;
    }

    /**
     * 
     */
    public function addExtId()
    {
        $this->convertor->getOutput()->setDataValue('id',
            'ext:src:'.$this->convertor->getInput()->getEvidence().':'.$this->convertor->getInput()->getMyKey());
    }

    /**
     * Complied Rules Getter
     * 
     * @return array
     */
    function getRules()
    {
        return $this->rules;
    }

    /**
     * 
     * 
     * @param string $columnName
     * 
     * @return string 
     */
    function getRuleForColumn($columnName)
    {
        return $this->rules[$columnName];
    }

    /**
     * Convertor Rule Clas  template Generator
     * 
     * @param Convertor $convertor
     * @param string    $className
     * 
     * @return string   Generated class filename
     * 
     * @throws \Ease\Exception
     */
    public static function convertorClassTemplateGenerator($convertor,
                                                           $className)
    {
        $inputColumns  = $convertor->getInput()->getColumnsInfo();
        $outputColumns = $convertor->getOutput()->getColumnsInfo();

        $oposites = self::getOposites($inputColumns, $outputColumns);

        $inputRelations = $convertor->getInput()->getRelationsInfo();
        if (!empty($inputRelations)) {
            if (array_key_exists('polozkyDokladu',
                    \Ease\Functions::reindexArrayBy($inputRelations, 'url'))) {
                $outSubitemsInfo            = $convertor->getOutput()->getColumnsInfo($convertor->getOutput()->getEvidence().'-polozka');
                $inSubitemsInfo             = $convertor->getInput()->getColumnsInfo($convertor->getInput()->getEvidence().'-polozka');
                $oposites['polozkyDokladu'] = self::getOposites($inSubitemsInfo,
                        $outSubitemsInfo);
            }
        }

        $classFile = '<?php
namespace AbraFlexi\Bricks\ConvertRules;
/**
 * Description of '.$className.'
 *
 * @author EaseAbraFlexiConvertorRule <info@vitexsoftware.cz>
 */
class '.$className.' extends \AbraFlexi\Bricks\ConvertorRule
{
    public $rules = ';

        $classFile .= var_export($oposites, true);

        $classFile .= ';

}
';
        if (file_put_contents($className.'.php', $classFile)) {
            $convertor->addStatusMessage($classFile, 'success');
        } else {
            throw new \Ease\Exception(sprintf(_('Cannot save ClassFile: %s'),
                    $className.'.php'));
        }
        return $className.'.php';
    }

    public static function getOposites($inProps, $outProps)
    {
        foreach ($outProps as $colName => $colProps) {
            if ($colProps['isWritable'] == 'true') {
                if (array_key_exists($colName, $inProps)) {
                    $outProps[$colName] = $colName;
                } else {
                    $outProps[$colName] = null;
                }
            } else {
                unset($outProps[$colName]);
            }
        }

        return $outProps;
    }

    /**
     * Actions performed after converting process
     * 
     * @return boolean
     */
    public function finalizeConversion()
    {
        return true;
    }
}
