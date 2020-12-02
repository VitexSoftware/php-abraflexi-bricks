<?php
/**
 * AbraFlexi Bricks - GDPR Logger support
 *
 * @author     Vítězslav Dvořák <info@vitexsofware.cz>
 * @copyright  (G) 2017-2019 Vitex Software
 */

namespace AbraFlexi\Bricks;
/**
 * Description of CustomerLog
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class GdprLog extends \Ease\GdprLog
{
    /**
     * Log AbraFlexi event
     * 
     * @param \AbraFlexi\RW $abraflexi
     * @param array $columns
     */
    public function logAbraFlexiEvent($abraflexi, $columns)
    {
        foreach ($columns as $columnName) {
            $this->logEvent($columnName,
                empty($abraflexi->lastInsertedID) ? 'update' : 'create', null,
                $abraflexi->getApiURL().'#'.$columnName);
        }
    }

    /**
     * Log Change in AbraFlexi
     * 
     * @param \AbraFlexi\RW $abraflexi
     * @param array $originalData
     * @param array $columns
     */
    public function logAbraFlexiChange($abraflexi, $originalData, $columns)
    {
        foreach ($columns as $columnName) {
            if ($originalData[$columnName] != $abraflexi->getDataValue($columnName)) {
                $this->logEvent($columnName, $abraflexi->getLastOperationType(), null,
                    $abraflexi->getApiURL().'#'.$columnName);
            }
        }
    }

}
