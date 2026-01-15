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

namespace AbraFlexi\Bricks;

/**
 * Description of ConvertorRule.
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class ConvertorRule extends \Ease\Sand
{
    /**
     * Summary of rules.
     *
     * @var array<string, array<string, string>|string>
     */
    public array $rules = [];
    public Convertor $convertor;
    private bool $keepId = false;
    private bool $addExtId = false;
    private bool $keepCode = false;

    /**
     * Conversion Rule.
     *
     * @param Convertor $convertor        Convertor Engine
     * @param bool      $keepId           Keep original ID in cloned document
     * @param bool      $addExtId         Add automatically generated ext:id based on source
     * @param bool      $keepCode         Keep original code: in cloned document
     * @param bool      $handleAccounting set columns "ucetni" like target or ignore it
     */
    public function __construct(
        ?Convertor &$convertor = null,
        $keepId = false,
        $addExtId = false,
        $keepCode = false,
        $handleAccounting = true,
    ) {
        $this->keepId = $keepId;
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

    public function assignConvertor(Convertor &$convertor): void
    {
        $this->convertor = &$convertor;
    }

    /**
     * Get Convertor used.
     *
     * @return Convertor
     */
    public function getConvertor()
    {
        return $this->convertor;
    }

    /**
     * Add ExtID by Original ID Into converted.
     */
    public function addExtId(): void
    {
        $this->convertor->getOutput()->setDataValue(
            'id',
            'ext:src:'.$this->convertor->getInput()->getEvidence().':'.$this->convertor->getInput()->getMyKey(),
        );
    }

    /**
     * Complied Rules Getter.
     *
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param string $columnName
     *
     * @return string
     */
    public function getRuleForColumn($columnName)
    {
        return $this->rules[$columnName];
    }

    /**
     * Get the output relation path for subitems.
     *
     * @param string $inputRelationPath Input relation path (e.g. "polozkyDokladu")
     *
     * @return string Output relation path
     */
    public function getOutputRelationPath($inputRelationPath)
    {
        // Default behavior: use the same path as input
        return $inputRelationPath;
    }

    /**
     * Convertor Rule Class  template Generator.
     *
     * @param Convertor $convertor
     * @param string    $className
     *
     * @throws \Ease\Exception
     *
     * @return string Generated class filename
     */
    public static function convertorClassTemplateGenerator(
        $convertor,
        $className,
    ) {
        $inputColumns = $convertor->getInput()->getColumnsInfo();
        $outputColumns = $convertor->getOutput()->getColumnsInfo();

        $oposites = self::getOposites($inputColumns, $outputColumns);

        $inputRelations = $convertor->getInput()->getRelationsInfo();

        if (!empty($inputRelations)) {
            if (
                \array_key_exists(
                    'polozkyDokladu',
                    \Ease\Functions::reindexArrayBy($inputRelations, 'url'),
                )
            ) {
                $outSubitemsInfo = $convertor->getOutput()->getColumnsInfo($convertor->getOutput()->getEvidence().'-polozka');
                $inSubitemsInfo = $convertor->getInput()->getColumnsInfo($convertor->getInput()->getEvidence().'-polozka');
                $oposites['polozkyDokladu'] = self::getOposites(
                    $inSubitemsInfo,
                    $outSubitemsInfo,
                );
            }
        }

        $classFile = <<<'EOD'
<?php
namespace AbraFlexi\Bricks\ConvertRules;
/**
 * Description of
EOD.$className.<<<'EOD'

 *
 * @author EaseAbraFlexiConvertorRule <info@vitexsoftware.cz>
 */
class
EOD.$className.<<<'EOD'
 extends \AbraFlexi\Bricks\ConvertorRule
{
    public $rules =
EOD;

        $classFile .= var_export($oposites, true);

        $classFile .= <<<'EOD'
;

}

EOD;
        $classFileName = sys_get_temp_dir().'/'.$className.'.php';

        if (file_put_contents($classFileName, $classFile)) {
            $convertor->addStatusMessage($classFileName, 'success');
        } else {
            throw new \Ease\Exception(sprintf(_('Cannot save ClassFile: %s'), $classFileName));
        }

        return $classFileName;
    }

    public static function getOposites($inProps, $outProps)
    {
        foreach ($outProps as $colName => $colProps) {
            if (\array_key_exists('isWritable', $colProps) && ($colProps['isWritable'] === 'true')) {
                if (\array_key_exists($colName, $inProps)) {
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
     * Actions performed after converting process.
     */
    public function finalizeConversion(): bool
    {
        return true;
    }
}
